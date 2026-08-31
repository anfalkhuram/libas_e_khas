<?php
require_once('inc/admin-top.php');
?>

<body>
    <?php
    require_once('inc/admin-sidebar.php');
    ?>
    

    <div class="admin-content">
        <?php   
        require_once('inc/admin-topbar.php');
        ?>

        <div class="container-fluid p-4">
            <h2 class="font-heading mb-4">Product Reviews</h2>

            <div class="bg-white p-4 rounded shadow-sm border-top border-3 border-gold">
                <div class="table-responsive">
                    <table class="table table-hover font-body align-middle datatable w-100">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>Customer</th>
                                <th>Rating</th>
                                <th class="admin-th-review">Review</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once('../inc/db.php');
                            $sql = "SELECT r.*, p.name as product_name, p.main_image FROM reviews r JOIN products p ON r.product_id = p.id ORDER BY r.created_at DESC";
                            $result = $conn->query($sql);
                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $id = $row['id'];
                                    $pName = htmlspecialchars($row['product_name']);
                                    $pImg = htmlspecialchars($row['main_image']);
                                    $cName = htmlspecialchars($row['name']);
                                    $rating = intval($row['rating']);
                                    $text = htmlspecialchars($row['review_text']);
                                    $date = date('M d, Y', strtotime($row['created_at']));
                                    $status = intval($row['status']);
                                    
                                    $stars = '';
                                    for ($i = 0; $i < 5; $i++) {
                                        $stars .= ($i < $rating) ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                                    }
                                    
                                    if ($status === 0) {
                                        $statusHtml = '<span class="badge bg-warning text-dark">Pending</span>';
                                        $actionHtml = '<button class="btn btn-sm btn-outline-success me-1 approve-btn" data-id="'.$id.'"><i class="fas fa-check"></i></button>
                                                       <button class="btn btn-sm btn-outline-danger delete-btn" data-id="'.$id.'"><i class="fas fa-times"></i></button>';
                                    } else {
                                        $statusHtml = '<span class="badge bg-success">Approved</span>';
                                        $actionHtml = '<button class="btn btn-sm btn-outline-danger delete-btn" data-id="'.$id.'"><i class="fas fa-trash"></i></button>';
                                    }
                                    
                                    echo "<tr>
                                            <td>
                                                <div class='d-flex align-items-center'>
                                                    <img src='../$pImg' class='me-2 admin-table-img-sm'>
                                                    <span>$pName</span>
                                                </div>
                                            </td>
                                            <td>$cName</td>
                                            <td class='text-gold'>$stars</td>
                                            <td class='small text-muted'>$text</td>
                                            <td>$date</td>
                                            <td>$statusHtml</td>
                                            <td>$actionHtml</td>
                                          </tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php
    require_once('inc/admin-bottom.php');
    ?>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.approve-btn').forEach(btn => {
                btn.addEventListener('click', async (e) => {
                    const id = e.currentTarget.dataset.id;
                    const result = await Swal.fire({
                        title: 'Approve this review?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#198754',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, approve it!'
                    });
                    
                    if(result.isConfirmed) {
                        try {
                            const res = await fetch(`ajax/approve-review.php?id=${id}`);
                            const data = await res.json();
                            if(data.success) {
                                await Swal.fire({icon: 'success', title: 'Approved!', showConfirmButton: false, timer: 1500});
                                location.reload();
                            }
                            else Swal.fire('Error', data.error || 'Failed to approve', 'error');
                        } catch(err) {
                            console.error(err);
                            Swal.fire('Error', 'An error occurred.', 'error');
                        }
                    }
                });
            });

            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', async (e) => {
                    const id = e.currentTarget.dataset.id;
                    const result = await Swal.fire({
                        title: 'Delete this review?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete it!'
                    });
                    
                    if(result.isConfirmed) {
                        try {
                            const res = await fetch(`ajax/delete-review.php?id=${id}`);
                            const data = await res.json();
                            if(data.success) {
                                await Swal.fire({icon: 'success', title: 'Deleted!', showConfirmButton: false, timer: 1500});
                                location.reload();
                            }
                            else Swal.fire('Error', data.error || 'Failed to delete', 'error');
                        } catch(err) {
                            console.error(err);
                            Swal.fire('Error', 'An error occurred.', 'error');
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>