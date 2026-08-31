<?php
$catName = isset($_GET['cat']) ? htmlspecialchars(trim($_GET['cat'])) : '';
$subcatName = isset($_GET['subcat']) ? htmlspecialchars(trim($_GET['subcat'])) : '';

if (!empty($subcatName)) {
    $pageTitle = "$subcatName | Libas-e-Khas";
    $metaDescription = "Shop our exclusive $subcatName collection at Libas-e-Khas. Find premium Pakistani fashion tailored to your unique style.";
} else if (!empty($catName)) {
    $pageTitle = "$catName | Libas-e-Khas";
    $metaDescription = "Shop the latest $catName collection from Libas-e-Khas. Discover elegance and craftsmanship in every piece.";
} else {
    $pageTitle = "Shop | Libas-e-Khas";
    $metaDescription = "Explore the complete collection of elegant Pakistani clothing at Libas-e-Khas. Timeless designs for every occasion.";
}

require_once('inc/top.php');
?>

<body>

    <!-- Announcement Bar -->
    <div class="announcement-bar">
        Elegance Crafted for Your Most Beautiful Moments
    </div>

    <!-- Header -->
    <?php
    require_once('inc/header.php');
    ?>

    <div class="shop-hero-header">
        <div class="container fade-up">
            <h1 class="heading-editorial">Shop Collection</h1>
            <p>Explore our curated collection of Pakistani fashion.</p>

            <div class="category-tabs mt-4">
                <button class="category-tab active" data-category="All">All</button>
                <?php
                require_once('inc/db.php');
                $shop_cat_sql = "SELECT id, name FROM categories WHERE status = 1";
                $shop_cat_res = $conn->query($shop_cat_sql);
                if ($shop_cat_res && $shop_cat_res->num_rows > 0) {
                    while($cat_row = $shop_cat_res->fetch_assoc()) {
                        $cat_name = htmlspecialchars($cat_row['name']);
                        echo '<button class="category-tab" data-category="' . $cat_name . '">' . $cat_name . '</button>';
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <section class="py-5 bg-ivory">
        <div class="container-fluid px-4 px-lg-5">

            <div class="row">
                <!-- Desktop Sidebar -->
                <div class="col-lg-3 d-none d-lg-block pe-5">

                    <!-- Search Box -->
                    <div class="mb-5">
                        <h4 class="sidebar-heading mb-2 font-heading fs-3 text-none">Search</h4>
                        <div class="border-bottom mb-4 border-divider"></div>
                        <form class="d-flex" id="shopDesktopSearchForm">
                            <input type="text" id="shopSearchInput" class="form-control rounded-0 border-dark border-end-0 shadow-none font-body py-2 px-3 fs-6" placeholder="Search products...">
                            <button class="btn rounded-0 text-white d-flex align-items-center justify-content-center bg-dark border-dark shop-search-btn" type="submit" aria-label="Search">
                                <i class="fas fa-search fs-5"></i>
                            </button>
                        </form>
                    </div>

                    <?php
                    // Pre-fetch all active subcategories and group by category_id
                    $shop_subcats = [];
                    $shop_all_sub_sql = "SELECT id, name, category_id FROM sub_categories WHERE status = 1";
                    $shop_all_sub_res = $conn->query($shop_all_sub_sql);
                    if ($shop_all_sub_res && $shop_all_sub_res->num_rows > 0) {
                        while($sub = $shop_all_sub_res->fetch_assoc()) {
                            $shop_subcats[$sub['category_id']][] = $sub;
                        }
                    }

                    if ($shop_cat_res && $shop_cat_res->num_rows > 0) {
                        $shop_cat_res->data_seek(0);
                        while($cat_row = $shop_cat_res->fetch_assoc()) {
                            $cat_id = $cat_row['id'];
                            $cat_name = htmlspecialchars($cat_row['name']);
                            
                            if (isset($shop_subcats[$cat_id]) && count($shop_subcats[$cat_id]) > 0) {
                                ?>
                                <div class="mb-5">
                                    <h4 class="sidebar-heading"><?php echo $cat_name; ?></h4>
                                    <ul class="sidebar-list">
                                        <?php foreach($shop_subcats[$cat_id] as $sub_row) { 
                                            $sub_name = htmlspecialchars($sub_row['name']);
                                        ?>
                                        <li><a href="#" class="category-tab" data-category="<?php echo $sub_name; ?>"><?php echo $sub_name; ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <?php
                            }
                        }
                    }
                    ?>
                    <!-- Price Filter -->
                    <div class="mb-5">
                        <h4 class="sidebar-heading mb-2 font-heading fs-3 text-none">Price Filter</h4>
                        <div class="border-bottom mb-4 border-divider"></div>

                        <form id="shopDesktopPriceForm">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <input type="number" id="minPriceInput" class="form-control rounded-0 px-2 shop-price-input shadow-none font-body" placeholder="Min">
                                <span class="mx-1 text-dark fw-medium">-</span>
                                <input type="number" id="maxPriceInput" class="form-control rounded-0 px-2 shop-price-input shadow-none font-body" placeholder="Max">
                            </div>
                            <button type="submit" class="btn w-100 bg-white border-dark text-dark font-body rounded py-2">
                                Apply Filter
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Product Grid -->
                <div class="col-lg-9">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom border-divider text-muted fs-6">
                        <!-- Mobile Filter Trigger -->
                        <button class="btn border border-dark bg-white d-lg-none rounded-0 px-3 py-2 font-body text-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                        <div class="d-flex align-items-center gap-2 ms-auto">
                            <select class="form-select border border-dark rounded-0 px-3 py-2 shadow-none font-body shop-sort-select" id="shopSortSelect">
                                <option value="featured" selected>Default Sorting</option>
                                <option value="new">Newest</option>
                                <option value="low">Price: Low to High</option>
                                <option value="high">Price: High to Low</option>
                            </select>
                        </div>
                    </div>

                    <!-- Mobile Search Box (Next Row) -->
                    <div class="d-lg-none mb-4 pb-3 border-bottom border-divider">
                        <form class="d-flex" id="shopMobileSearchForm">
                            <input type="text" id="shopMobileSearchInput" class="form-control rounded-0 border-dark border-end-0 shadow-none font-body py-2 px-3" placeholder="Search products...">
                            <button class="btn rounded-0 text-white d-flex align-items-center justify-content-center bg-dark border-dark shop-search-btn-mobile" type="submit" aria-label="Search">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                    <div class="row" id="product-grid">
                        <!-- Products rendered here via js/shop.js -->
                    </div>
                    <!-- Pagination Container -->
                    <div class="d-flex justify-content-center mt-5">
                        <nav aria-label="Page navigation">
                            <ul class="pagination rounded-0 gap-1" id="shop-pagination">
                                <!-- Pagination rendered here -->
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Filter Offcanvas for Mobile -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="filterOffcanvas">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title heading-section fs-4">Filters</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <h4 class="sidebar-heading">Categories</h4>
            <ul class="sidebar-list mb-4">
                <li><a href="#" class="category-tab" data-category="All" data-bs-dismiss="offcanvas">All Collections</a></li>
                <?php
                if ($shop_cat_res && $shop_cat_res->num_rows > 0) {
                    $shop_cat_res->data_seek(0);
                    while($cat_row = $shop_cat_res->fetch_assoc()) {
                        $cat_id = $cat_row['id'];
                        $cat_name = htmlspecialchars($cat_row['name']);
                        
                        if (isset($shop_subcats[$cat_id]) && count($shop_subcats[$cat_id]) > 0) {
                            echo '<li class="mt-3 fw-bold text-dark">' . $cat_name . '</li>';
                            foreach($shop_subcats[$cat_id] as $sub_row) {
                                $sub_name = htmlspecialchars($sub_row['name']);
                                echo '<li><a href="#" class="category-tab ms-3" data-category="' . $sub_name . '" data-bs-dismiss="offcanvas">' . $sub_name . '</a></li>';
                            }
                        } else {
                            echo '<li class="mt-2"><a href="#" class="category-tab fw-bold text-dark" data-category="' . $cat_name . '" data-bs-dismiss="offcanvas">' . $cat_name . '</a></li>';
                        }
                    }
                }
                ?>
            </ul>

            <div class="mb-4">
                <h4 class="sidebar-heading mb-2 font-heading fs-3 text-none">Price Filter</h4>
                <div class="border-bottom mb-4 border-divider"></div>
                <form id="shopMobilePriceForm" data-bs-dismiss="offcanvas">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <input type="number" id="minPriceInputMobile" class="form-control rounded-0 px-2 shop-price-input shadow-none font-body" placeholder="Min">
                        <span class="mx-1 text-dark fw-medium">-</span>
                        <input type="number" id="maxPriceInputMobile" class="form-control rounded-0 px-2 shop-price-input shadow-none font-body" placeholder="Max">
                    </div>
                    <button type="submit" class="btn w-100 bg-dark text-white font-body rounded py-2">
                        Apply Filter
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Quick View Modal -->
    <div class="modal fade" id="quickViewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 rounded-0">
                <div class="modal-body p-0 position-relative">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3 z-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="row g-0">
                        <div class="col-md-6">
                            <img src="" id="qv-img" class="img-fluid w-100 h-100 object-fit-cover shop-qv-img" alt="Product" width="400" height="500">
                        </div>
                        <div class="col-md-6 d-flex align-items-center">
                            <div class="p-4 p-lg-5 w-100 text-center text-md-start">
                                <span class="label-small" id="qv-category">Category</span>
                                <h2 class="heading-section fs-3 mb-3 mt-2" id="qv-title">Product Name</h2>
                                <div class="fs-5 mb-4 fw-medium" id="qv-price">PKR 0</div>
                                <p class="text-muted mb-4 fs-6">Experience luxury craftsmanship with this stunning piece, carefully tailored to perfection with delicate details.</p>

                                <div class="row g-3 mb-4">
                                    <div class="col-6">
                                        <select class="form-select rounded-0" id="qv-size" aria-label="Size">
                                            <option selected>Select Size</option>
                                            <option value="s">Small</option>
                                            <option value="m">Medium</option>
                                            <option value="l">Large</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <input type="number" class="form-control rounded-0" id="qv-qty" value="1" min="1" aria-label="Quantity">
                                    </div>
                                </div>

                                <button class="btn btn-primary w-100 py-3 mb-3" id="qv-add-to-cart">Add to Cart</button>
                                <button class="btn btn-outline-dark w-100 py-2 border-0 font-body text-uppercase fs-7 fw-medium" type="button" id="qvWishlistBtn">
                                    <i class="far fa-heart me-2"></i> Add to Wishlist
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cart Offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas">
        <div class="offcanvas-header border-bottom border-light">
            <h5 class="offcanvas-title font-heading">Your Bag</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column bg-ivory">
            <div id="cart-items" class="flex-grow-1 overflow-auto pe-2"></div>
            <div class="cart-footer mt-4 border-top pt-3">
                <div class="d-flex justify-content-between mb-3">
                    <span class="font-body fw-medium">Subtotal</span>
                    <span id="cart-subtotal" class="font-weight-bold">PKR 0</span>
                </div>
                <a href="checkout" class="btn btn-primary w-100 py-3">Proceed to Checkout</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php
    require_once('inc/footer.php');
    ?>

    <!-- Bottom -->
    <?php
    require_once('inc/bottom.php');
    ?>
    <script src="js/shop.js?v=<?php echo time(); ?>"></script>
</body>

</html>