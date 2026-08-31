<?php
require_once('../inc/db.php');
require_once('inc/admin-top.php');

// Handle Status Update
if (isset($_GET['update_status']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $status = $_GET['update_status'];
    $allowed_statuses = ['Pending', 'In Progress', 'Delivered', 'Cancelled'];
    
    if (in_array($status, $allowed_statuses)) {
        $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: orders");
    exit();
}

// Handle Order Deletion
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    // Due to ON DELETE CASCADE, order_details will also be deleted
    // First, optionally delete the payment proof file
    $stmt = $conn->prepare("SELECT payment_proof FROM orders WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($proof);
    if ($stmt->fetch() && !empty($proof) && file_exists('../' . $proof)) {
        unlink('../' . $proof);
    }
    $stmt->close();
    
    $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    
    header("Location: orders.php");
    exit();
}

require_once('inc/admin-topbar.php');
?>
<div class="d-flex">
    <?php require_once('inc/admin-sidebar.php'); ?>

    <div class="admin-content flex-grow-1 bg-light">
        <div class="container-fluid p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h3 font-heading mb-0">Manage Orders</h2>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4 text-nowrap">Order ID</th>
                                    <th class="text-nowrap">Name</th>
                                    <th class="text-nowrap">Address</th>
                                    <th class="text-nowrap">Phone</th>
                                    <th class="text-nowrap">Payment Method</th>
                                    <th class="text-nowrap">Payment Proof</th>
                                    <th class="text-nowrap">Status</th>
                                    <th class="text-end pe-4 text-nowrap">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM orders ORDER BY created_at DESC";
                                $res = $conn->query($sql);
                                
                                $modals = '';
                                if ($res && $res->num_rows > 0) {
                                    while ($row = $res->fetch_assoc()) {
                                        $id = intval($row['id']);
                                        $customer = htmlspecialchars(($row['first_name'] ?? '') . ' ' . ($row['last_name'] ?? ''));
                                        $address = htmlspecialchars(($row['address'] ?? '') . ' ' . ($row['city'] ?? ''));
                                        $phone = htmlspecialchars($row['phone'] ?? '');
                                        $method = htmlspecialchars($row['payment_method'] ?? '');
                                        $status = htmlspecialchars($row['status'] ?? '');
                                        
                                        $badgeClass = 'bg-secondary';
                                        if ($status === 'Pending') $badgeClass = 'bg-warning text-dark';
                                        if ($status === 'In Progress') $badgeClass = 'bg-info text-dark';
                                        if ($status === 'Delivered') $badgeClass = 'bg-success';
                                        if ($status === 'Cancelled') $badgeClass = 'bg-danger';
                                        
                                        echo '<tr>';
                                        echo '<td class="ps-4 fw-bold">#LK-'.str_pad($id, 5, '0', STR_PAD_LEFT).'</td>';
                                        echo '<td>'.$customer.'</td>';
                                        echo '<td>'.$address.'</td>';
                                        echo '<td>'.$phone.'</td>';
                                        echo '<td>'.$method.'</td>';
                                        
                                        // Payment Proof column
                                        echo '<td>';
                                        if ($method !== 'COD' && !empty($row['payment_proof'])) {
                                            echo '<a href="../'.htmlspecialchars($row['payment_proof']).'" data-bs-toggle="modal" data-bs-target="#imageModal" class="text-decoration-none view-image-btn">
                                                    <img src="../'.htmlspecialchars($row['payment_proof']).'" alt="Proof" style="width: 40px; height: 40px; object-fit: cover;" class="rounded border">
                                                  </a>';
                                        } else {
                                            echo '<span class="text-muted small">-</span>';
                                        }
                                        echo '</td>';
                                        
                                        echo '<td><span class="badge '.$badgeClass.'">'.$status.'</span></td>';
                                        echo '<td class="text-end pe-4">';
                                        echo '<div class="d-flex flex-nowrap gap-1 justify-content-end align-items-center">';
                                        echo '<button type="button" class="btn btn-sm btn-outline-dark view-order-btn" data-id="'.$id.'" data-bs-toggle="modal" data-bs-target="#orderModal'.$id.'">View</button>';
                                        
                                        if ($status === 'Pending') {
                                            echo '<a href="?update_status=In Progress&id='.$id.'" class="btn btn-sm btn-info text-dark" title="Mark In Progress"><i class="fas fa-spinner"></i></a>';
                                            echo '<a href="?update_status=Cancelled&id='.$id.'" class="btn btn-sm btn-danger" title="Cancel Order"><i class="fas fa-times"></i></a>';
                                        } elseif ($status === 'In Progress') {
                                            echo '<a href="?update_status=Delivered&id='.$id.'" class="btn btn-sm btn-success" title="Mark Delivered"><i class="fas fa-check-double"></i></a>';
                                            echo '<a href="?update_status=Cancelled&id='.$id.'" class="btn btn-sm btn-danger" title="Cancel Order"><i class="fas fa-times"></i></a>';
                                        }
                                        
                                        echo '<button class="btn btn-sm btn-outline-danger delete-order-btn" data-id="'.$id.'"><i class="fas fa-trash"></i></button>';
                                        echo '</div>';
                                        echo '</td>';
                                        echo '</tr>';

                                        // Modal for Order Details
                                        ob_start();
                                        ?>
                                        <div class="modal fade" id="orderModal<?=$id?>" tabindex="-1" aria-hidden="true">
                                          <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                              <div class="modal-header border-bottom-0 pb-0">
                                                <h5 class="modal-title fw-bold">Order #LK-<?=str_pad($id, 5, '0', STR_PAD_LEFT)?></h5>
                                                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                                              </div>
                                              <div class="modal-body">
                                                <div class="row g-4 mb-4">
                                                    <div class="col-md-6">
                                                        <h6 class="fw-bold mb-3 text-muted">Customer Information</h6>
                                                        <p class="mb-1"><strong>Name:</strong> <?=htmlspecialchars(($row['first_name'] ?? '').' '.($row['last_name'] ?? ''))?></p>
                                                        <p class="mb-1"><strong>Email:</strong> <?=htmlspecialchars($row['email'] ?? '')?></p>
                                                        <p class="mb-1"><strong>Phone:</strong> <?=htmlspecialchars($row['phone'] ?? '')?></p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6 class="fw-bold mb-3 text-muted">Shipping Address</h6>
                                                        <p class="mb-1"><?=htmlspecialchars($row['address'] ?? '')?></p>
                                                        <?php if(!empty($row['apartment'])) echo '<p class="mb-1">'.htmlspecialchars($row['apartment']).'</p>'; ?>
                                                        <p class="mb-1"><?=htmlspecialchars(($row['city'] ?? '').', '.($row['postal_code'] ?? ''))?></p>
                                                        <p class="mb-0"><?=htmlspecialchars($row['country'] ?? '')?></p>
                                                    </div>
                                                </div>

                                                <h6 class="fw-bold mb-3 text-muted">Order Details</h6>
                                                <div class="table-responsive mb-4">
                                                    <table class="table table-sm table-bordered">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Product</th>
                                                                <th>Size</th>
                                                                <th>Qty</th>
                                                                <th>Price</th>
                                                                <th>Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $det_sql = "SELECT od.*, p.main_image FROM order_details od LEFT JOIN products p ON od.product_id = p.id WHERE od.order_id = $id";
                                                            $det_res = $conn->query($det_sql);
                                                            if ($det_res && $det_res->num_rows > 0) {
                                                                while ($dRow = $det_res->fetch_assoc()) {
                                                                    $pTotal = $dRow['quantity'] * $dRow['price'];
                                                                    $imgSrc = !empty($dRow['main_image']) ? '../'.htmlspecialchars($dRow['main_image']) : '../assets/images/placeholder.webp'; // Fallback
                                                                    
                                                                    echo '<tr>';
                                                                    echo '<td>
                                                                            <div class="d-flex align-items-center">
                                                                                <img src="'.$imgSrc.'" alt="Product" style="width: 50px; height: 60px; object-fit: cover;" class="rounded shadow-sm me-3 border">
                                                                                <span class="fw-medium">'.htmlspecialchars($dRow['product_name'] ?? '').'</span>
                                                                            </div>
                                                                          </td>';
                                                                    echo '<td class="align-middle">'.htmlspecialchars($dRow['product_size'] ?? '').'</td>';
                                                                    echo '<td class="align-middle">'.$dRow['quantity'].'</td>';
                                                                    echo '<td class="align-middle">PKR '.number_format($dRow['price'], 2).'</td>';
                                                                    echo '<td class="align-middle fw-medium">PKR '.number_format($pTotal, 2).'</td>';
                                                                    echo '</tr>';
                                                                }
                                                            }
                                                            ?>
                                                        </tbody>
                                                        <tfoot class="table-light">
                                                            <tr>
                                                                <td colspan="4" class="text-end fw-bold">Grand Total:</td>
                                                                <td class="fw-bold text-gold">PKR <?=number_format($row['total_amount'], 2)?></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>

                                                <?php if ($method !== 'COD'): ?>
                                                <h6 class="fw-bold mb-3 text-muted">Payment Information</h6>
                                                <p class="mb-2"><strong>Method:</strong> <?=$method?></p>
                                                <?php if (!empty($row['payment_proof'])): ?>
                                                    <p class="mb-2"><strong>Payment Proof:</strong></p>
                                                    <a href="../<?=htmlspecialchars($row['payment_proof'])?>" data-bs-toggle="modal" data-bs-target="#imageModal" class="view-image-btn">
                                                        <img src="../<?=htmlspecialchars($row['payment_proof'])?>" alt="Payment Proof" class="img-thumbnail" style="max-width: 300px;">
                                                    </a>
                                                <?php else: ?>
                                                    <p class="text-danger">No payment proof uploaded.</p>
                                                <?php endif; ?>
                                                <?php endif; ?>

                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <?php
                                        $modals .= ob_get_clean();
                                    }
                                } else {
                                    echo '<tr><td colspan="7" class="text-center py-4 text-muted">No orders found.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php echo $modals ?? ''; ?>
            
            <!-- Image Viewer Modal -->
            <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
                <div class="modal-dialog modal-dialog-centered" style="max-width: 100vw; height: 100vh; margin: 0;">
                    <div class="modal-content bg-transparent border-0 h-100">
                        <div class="modal-header border-0 position-absolute top-0 end-0 z-3">
                            <button type="button" class="btn btn-dark rounded-circle shadow m-3 d-flex justify-content-center align-items-center" data-bs-dismiss="modal" aria-label="Close" style="width: 40px; height: 40px;">
                                <i class="fas fa-times fs-5"></i>
                            </button>
                        </div>
                        <div class="modal-body d-flex justify-content-center align-items-center h-100 p-0">
                            <img src="" id="imageModalSrc" style="max-height: 95vh; max-width: 95vw; object-fit: contain;" class="rounded shadow-lg" alt="Payment Proof">
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<?php require_once('inc/admin-bottom.php'); ?>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Image Modal Logic
    const imageLinks = document.querySelectorAll('.view-image-btn');
    imageLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const imgSrc = link.getAttribute('href');
            document.getElementById('imageModalSrc').src = imgSrc;
        });
    });

    const deleteBtns = document.querySelectorAll('.delete-order-btn');
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this! This will permanently delete the order.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `?delete=${id}`;
                }
            });
        });
    });
});
</script>
</body>
</html>
