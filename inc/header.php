  <header class="header">
    <nav class="navbar navbar-expand-lg">
      <div class="container-fluid px-4 px-lg-5">
        
        <!-- Mobile Toggle -->
        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fas fa-bars"></i>
        </button>

        <!-- Logo -->
        <a class="navbar-brand" href="index">
          <img src="assets/images/logo.webp" alt="Libas E Khas">
        </a>

        <!-- Desktop Navigation & Mobile Offcanvas -->
        <div class="offcanvas-lg offcanvas-start flex-grow-1" tabindex="-1" id="navbarMain" aria-labelledby="navbarMainLabel">
          <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title font-heading" id="navbarMainLabel">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#navbarMain" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 align-items-center gap-4">
            <li class="nav-item">
              <a class="nav-link px-3 <?php echo ($pageName == 'Shop') ? 'active' : ''; ?>" href="shop">Shop</a>
            </li>
            <?php 
            require_once('inc/db.php');
            
            // Pre-fetch all active subcategories and group by category_id
            $subcats = [];
            $all_sub_sql = "SELECT id, name, category_id FROM sub_categories WHERE status = 1";
            $all_sub_res = $conn->query($all_sub_sql);
            if ($all_sub_res && $all_sub_res->num_rows > 0) {
                while($sub = $all_sub_res->fetch_assoc()) {
                    $subcats[$sub['category_id']][] = $sub;
                }
            }
            
            $cat_sql = "SELECT id, name FROM categories WHERE status = 1";
            $cat_res = $conn->query($cat_sql);
            if ($cat_res && $cat_res->num_rows > 0) {
                while($cat_row = $cat_res->fetch_assoc()) {
                    $cat_id = $cat_row['id'];
                    $cat_name = htmlspecialchars($cat_row['name']);
                    
                    if (isset($subcats[$cat_id]) && count($subcats[$cat_id]) > 0) {
                        ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link px-3 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo $cat_name; ?>
                            </a>
                            <ul class="dropdown-menu border-0 rounded-0 shadow-sm">
                                <?php foreach($subcats[$cat_id] as $sub_row) { 
                                    $sub_name = htmlspecialchars($sub_row['name']);
                                ?>
                                <li><a class="dropdown-item" href="shop?subcat=<?php echo urlencode($sub_name); ?>"><?php echo $sub_name; ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php
                    } else {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link px-3" href="shop?cat=<?php echo urlencode($cat_name); ?>"><?php echo $cat_name; ?></a>
                        </li>
                        <?php
                    }
                }
            }
            ?>
            <li class="nav-item">
              <a class="nav-link px-3 <?php echo ($pageName == 'About Us' || $pageName == 'About') ? 'active' : ''; ?>" href="about">About Us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link px-3 <?php echo ($pageName == 'Contact Us' || $pageName == 'Contact') ? 'active' : ''; ?>" href="contact">Contact Us</a>
            </li>
          </ul>
        </div>
      </div>

      <!-- Right Icons -->
      <div class="nav-icons d-flex align-items-center">
        <button class="btn btn-link text-decoration-none position-relative" data-bs-toggle="offcanvas" data-bs-target="#cartOffcanvas">
          <i class="fas fa-shopping-bag"></i>
          <span class="cart-count">0</span>
        </button>
      </div>
        
      </div>
    </nav>
  </header>