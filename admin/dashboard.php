<?php 
    require_once ('inc/admin-top.php');
    require_once ('../inc/db.php');

    // Fetch catalog counts
    $total_categories = $conn->query("SELECT COUNT(*) FROM categories")->fetch_row()[0];
    $total_products = $conn->query("SELECT COUNT(*) FROM products")->fetch_row()[0];
    $instock_products = $conn->query("SELECT COUNT(*) FROM products WHERE availability = 'In Stock'")->fetch_row()[0];
    $outofstock_products = $conn->query("SELECT COUNT(*) FROM products WHERE availability = 'Out of Stock'")->fetch_row()[0];

    // Fetch order counts
    $total_orders = $conn->query("SELECT COUNT(*) FROM orders")->fetch_row()[0];
    $pending_orders = $conn->query("SELECT COUNT(*) FROM orders WHERE status = 'Pending'")->fetch_row()[0];
    $inprogress_orders = $conn->query("SELECT COUNT(*) FROM orders WHERE status = 'In Progress'")->fetch_row()[0];
    $delivered_orders = $conn->query("SELECT COUNT(*) FROM orders WHERE status = 'Delivered'")->fetch_row()[0];
    $cancelled_orders = $conn->query("SELECT COUNT(*) FROM orders WHERE status = 'Cancelled'")->fetch_row()[0];
?>
<body>

    <!-- Sidebar -->
    <?php 
        require_once ('inc/admin-sidebar.php');
    ?>

    <!-- Page Content -->
    <div class="admin-content">
        <!-- Topbar -->
       <?php 
            require_once ('inc/admin-topbar.php');
       ?>

        <!-- Main Dashboard Content -->
        <div class="container-fluid p-4">
            <h2 class="font-heading mb-4">Dashboard Overview</h2>

            <!-- Catalog Overview Cards -->
            <div class="row g-4 mb-4 font-body">
                <div class="col-xl-3 col-sm-6">
                    <div class="admin-card position-relative overflow-hidden h-100">
                        <div class="text-muted small fw-bold text-uppercase mb-1">Total Categories</div>
                        <div class="fs-3 fw-bold text-dark"><?= $total_categories ?></div>
                        <i class="fas fa-list card-icon"></i>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="admin-card position-relative overflow-hidden h-100">
                        <div class="text-muted small fw-bold text-uppercase mb-1">Total Products</div>
                        <div class="fs-3 fw-bold text-dark"><?= $total_products ?></div>
                        <i class="fas fa-tshirt card-icon"></i>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="admin-card position-relative overflow-hidden h-100">
                        <div class="text-muted small fw-bold text-uppercase mb-1">In Stock Products</div>
                        <div class="fs-3 fw-bold text-dark"><?= $instock_products ?></div>
                        <i class="fas fa-check-circle card-icon"></i>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="admin-card position-relative overflow-hidden h-100">
                        <div class="text-muted small fw-bold text-uppercase mb-1">Out of Stock</div>
                        <div class="fs-3 fw-bold text-dark"><?= $outofstock_products ?></div>
                        <i class="fas fa-exclamation-triangle card-icon"></i>
                    </div>
                </div>
            </div>

            <!-- Order Overview Cards -->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-5 g-4 mb-4 font-body">
                <div class="col">
                    <div class="admin-card position-relative overflow-hidden h-100 border-start border-4 border-dark">
                        <div class="text-dark small fw-bold text-uppercase mb-1">Total Orders</div>
                        <div class="fs-3 fw-bold text-dark"><?= $total_orders ?></div>
                        <i class="fas fa-shopping-cart card-icon text-dark opacity-25"></i>
                    </div>
                </div>
                <div class="col">
                    <div class="admin-card position-relative overflow-hidden h-100 border-start border-4 border-warning">
                        <div class="text-warning small fw-bold text-uppercase mb-1">Pending</div>
                        <div class="fs-3 fw-bold text-warning"><?= $pending_orders ?></div>
                        <i class="fas fa-clock card-icon text-warning opacity-25"></i>
                    </div>
                </div>
                <div class="col">
                    <div class="admin-card position-relative overflow-hidden h-100 border-start border-4 border-info">
                        <div class="text-info small fw-bold text-uppercase mb-1">In Progress</div>
                        <div class="fs-3 fw-bold text-info"><?= $inprogress_orders ?></div>
                        <i class="fas fa-spinner card-icon text-info opacity-25"></i>
                    </div>
                </div>
                <div class="col">
                    <div class="admin-card position-relative overflow-hidden h-100 border-start border-4 border-success">
                        <div class="text-success small fw-bold text-uppercase mb-1">Delivered</div>
                        <div class="fs-3 fw-bold text-success"><?= $delivered_orders ?></div>
                        <i class="fas fa-check-double card-icon text-success opacity-25"></i>
                    </div>
                </div>
                <div class="col">
                    <div class="admin-card position-relative overflow-hidden h-100 border-start border-4 border-danger">
                        <div class="text-danger small fw-bold text-uppercase mb-1">Cancelled</div>
                        <div class="fs-3 fw-bold text-danger"><?= $cancelled_orders ?></div>
                        <i class="fas fa-times card-icon text-danger opacity-25"></i>
                    </div>
                </div>
            </div>

            <!-- Recent Orders Table -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="bg-white p-4 rounded shadow-sm border-top border-3 border-gold">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="font-heading mb-0">Recent Orders (Last 3 Days)</h5>
                            <a href="orders.php" class="btn btn-sm btn-dark font-body">View All Orders</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover font-body align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $recent_orders_sql = "SELECT id, first_name, last_name, total_amount, status, created_at FROM orders WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 3 DAY) ORDER BY created_at DESC";
                                    $recent_orders_res = $conn->query($recent_orders_sql);
                                    if ($recent_orders_res && $recent_orders_res->num_rows > 0) {
                                        while ($row = $recent_orders_res->fetch_assoc()) {
                                            $id = str_pad($row['id'], 5, '0', STR_PAD_LEFT);
                                            $customer = htmlspecialchars($row['first_name'] . ' ' . $row['last_name']);
                                            $date = date('M d, Y', strtotime($row['created_at']));
                                            $status = htmlspecialchars($row['status']);
                                            $total = number_format($row['total_amount'], 2);
                                            
                                            $badgeClass = 'bg-secondary';
                                            if ($status === 'Pending') $badgeClass = 'bg-warning text-dark';
                                            if ($status === 'In Progress') $badgeClass = 'bg-info text-dark';
                                            if ($status === 'Delivered') $badgeClass = 'bg-success';
                                            if ($status === 'Cancelled') $badgeClass = 'bg-danger';

                                            echo "<tr>
                                                    <td><strong>#LK-{$id}</strong></td>
                                                    <td>{$customer}</td>
                                                    <td>{$date}</td>
                                                    <td><span class=\"badge {$badgeClass} rounded-pill px-3\">{$status}</span></td>
                                                    <td>PKR {$total}</td>
                                                    <td>
                                                        <a href=\"orders.php\" class=\"btn btn-sm btn-outline-dark\"><i class=\"fas fa-eye\"></i></a>
                                                    </td>
                                                </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='6' class='text-center py-4 text-muted'>No recent orders in the last 3 days.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Scripts -->
    <?php 
        require_once ('inc/admin-bottom.php');
    ?>
</body>
</html>
