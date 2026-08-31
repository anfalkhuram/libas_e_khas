<div class="mobile-restricted-overlay">
    <div class="text-center p-4">
        <i class="fas fa-desktop fs-1 mb-3" style="color: var(--color-gold);"></i>
        <h4 class="font-heading fw-bold mb-2 text-dark">Desktop Recommended</h4>
        <p class="font-body text-muted small">For the best experience and to access all administrative features, please use a laptop or desktop computer.</p>
    </div>
</div>
<nav class="admin-sidebar">
        <div class="sidebar-header d-flex align-items-center justify-content-center gap-2">
            <img src="../assets/images/logo.webp" alt="Libas e Khas" class="logo admin-sidebar-logo">
            <span class="small fw-bold font-body text-uppercase" style="color: var(--color-gold); letter-spacing: 1px;">Boutique Admin</span>
        </div>

        <ul class="list-unstyled components font-body">
            <p>MAIN NAVIGATION</p>
            <li class="<?php echo ($pageName == 'Dashboard') ? 'active' : ''; ?>">
                <a href="dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            </li>
            <li class="<?php echo ($pageName == 'Orders') ? 'active' : ''; ?>">
                <?php
                $pending_orders_count = 0;
                $pending_query = $conn->query("SELECT COUNT(*) as count FROM orders WHERE status = 'Pending'");
                if ($pending_query) {
                    $pending_row = $pending_query->fetch_assoc();
                    $pending_orders_count = $pending_row['count'];
                }
                ?>
                <a href="orders"><i class="fas fa-shopping-cart"></i> Orders 
                    <?php if ($pending_orders_count > 0): ?>
                        <span class="badge bg-danger float-end mt-1"><?php echo $pending_orders_count; ?></span>
                    <?php endif; ?>
                </a>
            </li>
            <li>
                <a href="#productSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-tshirt"></i> Catalog</a>
                <ul class="collapse list-unstyled show" id="productSubmenu">
                    <li <?php echo ($pageName == 'Categories') ? 'class="active"' : ''; ?>><a href="categories" class="ps-5">Categories</a></li>
                    <li <?php echo ($pageName == 'Sub Categories') ? 'class="active"' : ''; ?>><a href="sub-categories" class="ps-5">Sub Categories</a></li>
                    <li <?php echo ($pageName == 'Products') ? 'class="active"' : ''; ?>><a href="products" class="ps-5">Products</a></li>
                    <li <?php echo ($pageName == 'Add Product') ? 'class="active"' : ''; ?>><a href="add-product" class="ps-5">Add Product</a></li>
                </ul>
            </li>
            <!-- <li>
                <a href="customers"><i class="fas fa-users"></i> Customers</a>
            </li> -->
            <li class="<?php echo ($pageName == 'Reviews') ? 'active' : ''; ?>">
                <a href="reviews"><i class="fas fa-star"></i> Reviews</a>
            </li>
            <li class="<?php echo ($pageName == 'Contacts') ? 'active' : ''; ?>">
                <a href="contacts"><i class="fas fa-envelope"></i> Contacts</a>
            </li>
           
        </ul>
    </nav>