<?php
http_response_code(404);
$pageTitle = "Page Not Found | Libas-e-Khas";
$metaDescription = "The page you are looking for could not be found at Libas-e-Khas. Please check the URL or browse our beautiful Pakistani clothing collections.";
$robotsMeta = "noindex, follow"; 
require_once('inc/top.php');
?>
<body>
    <!-- Header -->
    <?php require_once('inc/header.php'); ?>

    <section class="py-5 text-center min-vh-50 d-flex align-items-center justify-content-center">
        <div class="container fade-up">
            <h1 class="heading-editorial display-1 mb-3 text-dark">404</h1>
            <h2 class="heading-section fs-3 mb-4">Page Not Found</h2>
            <p class="text-muted mb-5 mx-auto" style="max-width: 500px;">
                We're sorry, but the page you are looking for doesn't exist or has been moved. 
                Explore our collections to find your perfect style.
            </p>
            <a href="shop" class="btn btn-primary px-5 py-3">Continue Shopping</a>
        </div>
    </section>

    <!-- Footer -->
    <?php require_once('inc/footer.php'); ?>
    <?php require_once('inc/bottom.php'); ?>
</body>
</html>
