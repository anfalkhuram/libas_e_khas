<?php
$pageTitle = "About Us | Libas-e-Khas";
$metaDescription = "Learn about the story behind Libas-e-Khas. We celebrate the beauty of Pakistani craftsmanship through thoughtfully designed silhouettes and timeless elegance.";
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

    <section class="about-hero fade-up">
        <div class="container">
            <span class="label-small mb-3 d-inline-block">Heritage & Artistry</span>
            <h1 class="heading-editorial">The Story Behind<br>Libas E Khas</h1>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row align-items-center mb-5 fade-up">
                <div class="col-md-6 mb-4 mb-md-0">
                    <img src="https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&q=80&w=1920" class="img-fluid w-100 about-craft-img" alt="Craftsmanship">
                </div>
                <div class="col-md-6 px-lg-5 text-center text-md-start">
                    <h2 class="heading-section mb-4">Our Philosophy</h2>
                    <p class="text-muted fs-5 lh-lg">
                        Every garment tells a story. At Libas E Khas, we create pieces that honour tradition while embracing contemporary elegance. Our designs are a tribute to the rich cultural heritage of Pakistan, woven delicately into every thread, crystal, and embellishment.
                    </p>
                    <p class="text-muted mt-3 fs-5 lh-lg">
                        From luxurious bridals to sophisticated party wear, we believe in celebrating femininity through exquisite craftsmanship.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-white">
        <div class="container text-center fade-up">
            <h2 class="heading-section mb-5">The Journey of Elegance</h2>

            <div class="timeline">
                <div class="timeline-item timeline-left fade-up">
                    <span class="label-small text-gold">Phase 01</span>
                    <h3 class="mt-2 mb-3 font-heading">Tradition</h3>
                    <p class="text-muted">Drawing inspiration from centuries-old Pakistani motifs, art, and architecture. We begin with a deep respect for our cultural roots.</p>
                </div>
                <div class="timeline-item timeline-right fade-up delay-100">
                    <span class="label-small text-gold">Phase 02</span>
                    <h3 class="mt-2 mb-3 font-heading">Craftsmanship</h3>
                    <p class="text-muted">Our artisans dedicate hundreds of hours to intricate Adda and Dabka work, ensuring every detail is perfectly executed by hand.</p>
                </div>
                <div class="timeline-item timeline-left fade-up delay-200">
                    <span class="label-small text-gold">Phase 03</span>
                    <h3 class="mt-2 mb-3 font-heading">Modern Elegance</h3>
                    <p class="text-muted">The final masterpiece brings together timeless techniques with contemporary silhouettes, creating fashion that transcends generations.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Cart Offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas">
        <div class="offcanvas-header border-bottom border-light">
            <h5 class="offcanvas-title font-heading">Your Bag</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
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
</body>

</html>