<?php
$pageTitle = "Libas-e-Khas | Elegant Pakistani Clothing & Fashion";
$metaDescription = "Shop elegant Pakistani fashion from Libas-e-Khas. Discover beautifully crafted silhouettes for timeless style and effortless sophistication.";

require_once('inc/top.php');
?>

<body>

    <!-- Loader -->
    <div id="loader">
        <img src="assets/images/logo.webp" alt="Libas E Khas Logo" class="loader-logo">
        <div class="loader-progress"></div>
    </div>

    <!-- Announcement Bar -->
    <div class="announcement-bar">
        Elegance Crafted for Your Most Beautiful Moments
    </div>

    <!-- Header -->
    <?php
    require_once('inc/header.php');
    ?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="gold-accent hero-gold-frame"></div>
        <div id="heroCarousel" class="carousel slide carousel-fade position-absolute top-0 start-0 w-100 h-100 hero-carousel-wrap" data-bs-ride="carousel" data-bs-interval="4000">
            <div class="carousel-inner w-100 h-100">
                <div class="carousel-item active w-100 h-100">
                    <img src="assets/images/hero-images/hero-image-1.webp" class="d-block w-100 h-100 object-fit-cover" alt="Bridal Fashion 1" fetchpriority="high">
                </div>
                <div class="carousel-item w-100 h-100">
                    <img src="assets/images/hero-images/hero-image-2.webp" class="d-block w-100 h-100 object-fit-cover" alt="Bridal Fashion 2" loading="lazy" decoding="async">
                </div>
                <div class="carousel-item w-100 h-100">
                    <img src="assets/images/hero-images/hero-image-3.webp" class="d-block w-100 h-100 object-fit-cover" alt="Bridal Fashion 3" loading="lazy" decoding="async">
                </div>
            </div>
        </div>
        <div class="hero-overlay"></div>

        <div class="hero-content fade-up text-center">
            <span class="label-small mb-3 d-inline-block">The Art of Pakistani Couture</span>
            <h1 class="heading-editorial mb-4">Elegance, Woven Into<br>Every Detail.</h1>
            <p>Discover timeless Pakistani silhouettes crafted for celebrations, traditions, and unforgettable moments.</p>

            <div class="d-flex flex-wrap justify-content-center gap-3">
                <a href="shop" class="btn btn-primary">Shop Collection</a>
                <a href="shop" class="btn btn-outline text-white border-white">Explore Bridal Wear</a>
            </div>
        </div>
    </section>

    <!-- Featured Categories -->
    <section class="py-5 my-md-5">
        <div class="container text-center mb-5 fade-up">
            <span class="label-small">Discover</span>
            <h2 class="heading-section mt-2">Explore Our Collections</h2>
        </div>

        <div class="container-fluid px-0">
            <div class="row g-0">
                <?php
                // Fetch categories
                $home_cat_sql = "SELECT id, name, image FROM categories WHERE status = 1";
                $home_cat_res = $conn->query($home_cat_sql);
                if ($home_cat_res && $home_cat_res->num_rows > 0) {
                    $delay = 0;
                    while($cat_row = $home_cat_res->fetch_assoc()) {
                        $delay_class = $delay > 0 ? " delay-" . $delay : "";
                        $cat_name = htmlspecialchars($cat_row['name']);
                        $cat_image = htmlspecialchars($cat_row['image']);
                        $image_path = 'assets/images/categories/' . $cat_image;
                        ?>
                        <div class="col-md-4 fade-up<?php echo $delay_class; ?>">
                            <a href="shop" class="category-card">
                                <img src="<?php echo $image_path; ?>" alt="<?php echo $cat_name; ?>" loading="lazy" decoding="async" width="400" height="500">
                                <div class="category-overlay">
                                    <div class="category-content text-center w-100">
                                        <h3 class="mb-2 text-white fw-bold "><?php echo $cat_name; ?></h3>
                                        <p class="text-white">Explore our exclusive <?php echo $cat_name; ?> collection.</p>
                                        <span class="btn btn-outline">Discover Collection</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php
                        $delay += 100;
                    }
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Curated Products -->
    <section class="py-5 bg-white">
        <div class="container text-center mb-5 fade-up">
            <span class="label-small">New Arrivals</span>
            <h2 class="heading-section mt-2">Curated For You</h2>
        </div>

        <div class="container">
            <div class="row" id="home-product-grid">
                <!-- Rendered dynamically by js/home.js -->
            </div>
            <div class="text-center mt-5 fade-up">
                <a href="shop" class="btn btn-outline">View All Products</a>
            </div>
        </div>
    </section>

    <!-- Brand Statement -->
    <section class="brand-statement">
        <div class="container-fluid px-0">
            <div class="row g-0 align-items-center">
                <div class="col-md-6 fade-up">
                    <img src="assets/images/hero-images/hero-image-2.webp" alt="Pakistani Craftsmanship" class="img-fluid w-100 brand-statement-img" loading="lazy" decoding="async" width="800" height="600">
                </div>
                <div class="col-md-6 text-center statement-text fade-up">
                    <h2 class="heading-section mb-4 text-center w-100 mx-auto">Crafted For Moments That Matter.</h2>
                    <p class="mx-auto text-center w-100">Libas E Khas celebrates the beauty of Pakistani craftsmanship through thoughtfully designed silhouettes, intricate detailing, and timeless elegance.</p>
                    <a href="about" class="btn btn-outline mt-4">Discover Our Story</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="features-section">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-3 feature-box fade-up">
                    <i class="fas fa-cut feature-icon"></i>
                    <h4>Exceptional Craftsmanship</h4>
                    <p>Intricate details made with care.</p>
                </div>
                <div class="col-12 col-md-3 feature-box fade-up delay-100">
                    <i class="far fa-gem feature-icon"></i>
                    <h4>Timeless Designs</h4>
                    <p>Classic Pakistani silhouettes with a modern expression.</p>
                </div>
                <div class="col-12 col-md-3 feature-box fade-up delay-200">
                    <i class="fas fa-fan feature-icon"></i>
                    <h4>Premium Fabrics</h4>
                    <p>Thoughtfully selected fabrics and finishes.</p>
                </div>
                <div class="col-12 col-md-3 feature-box fade-up delay-300">
                    <i class="fas fa-glass-cheers feature-icon"></i>
                    <h4>Made For Your Moments</h4>
                    <p>Designed for weddings, celebrations, and unforgettable occasions.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->

    <?php
    require_once('inc/footer.php');
    ?>

    <!-- Cart Offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas" aria-labelledby="cartOffcanvasLabel">
        <div class="offcanvas-header border-bottom border-light">
            <h5 class="offcanvas-title font-heading" id="cartOffcanvasLabel">Your Bag</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column bg-ivory">
            <div id="cart-items" class="flex-grow-1 overflow-auto pe-2">
                <!-- Cart items injected here -->
            </div>
            <div class="cart-footer mt-4 border-top pt-3">
                <div class="d-flex justify-content-between mb-3">
                    <span class="font-body fw-medium">Subtotal</span>
                    <span id="cart-subtotal" class="font-weight-bold">PKR 0</span>
                </div>
                <a href="checkout" class="btn btn-primary w-100 py-3">Proceed to Checkout</a>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <?php
    require_once('inc/bottom.php');
    ?>

    <script src="js/home.js"></script>
</body>

</html>