<?php
$pageTitle = "Contact Us | Libas-e-Khas";
$metaDescription = "Get in touch with Libas-e-Khas. We are here to help you with your orders, custom sizing requests, and any other inquiries regarding our Pakistani fashion.";
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

    <section class="contact-hero fade-up">
        <div class="container">
            <span class="label-small mb-3 d-inline-block">Get In Touch</span>
            <h1 class="heading-editorial">Let’s Create<br>Something Beautiful.</h1>
        </div>
    </section>

    <section class="py-5">
        <div class="container py-lg-5">
            <div class="row g-5">

                <!-- Contact Information -->
                <div class="col-lg-4 order-2 order-lg-1 fade-up">
                    <div class="contact-info-card text-center text-lg-start">
                        <h3 class="heading-section mb-5 fs-3">Our Details</h3>

                        <div class="contact-info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <h4>Visit Us</h4>
                            <p>123 Luxury Avenue,<br>Fashion District, Lahore</p>
                        </div>

                        <div class="contact-info-item">
                            <i class="fas fa-phone-alt"></i>
                            <h4>Call Us</h4>
                            <p>+92 300 1234567</p>
                        </div>

                        <div class="contact-info-item">
                            <i class="fab fa-whatsapp"></i>
                            <h4>WhatsApp</h4>
                            <p>+92 300 1234567</p>
                        </div>

                        <div class="contact-info-item">
                            <i class="far fa-envelope"></i>
                            <h4>Email</h4>
                            <p>hello@libasekhas.com</p>
                        </div>

                        <div class="mt-5 d-flex justify-content-center justify-content-lg-start gap-3">
                            <a href="#" class="text-dark" aria-label="Instagram"><i class="fab fa-instagram fs-4"></i></a>
                            <a href="#" class="text-dark" aria-label="Facebook"><i class="fab fa-facebook fs-4"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="col-lg-8 order-1 order-lg-2 fade-up delay-100">
                    <div class="p-4 p-lg-5 bg-white border h-100 contact-form-box">
                        <h3 class="heading-section mb-4 fs-3 text-center text-lg-start">Send a Message</h3>
                        <form id="contactForm" class="contact-form">
                            <div id="formAlert"></div>
                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <label for="name">Full Name</label>
                                    <input type="text" class="form-control" id="name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email">Email Address</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>
                            </div>
                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <label for="phone">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone">
                                </div>
                                <div class="col-md-6">
                                    <label for="subject">Subject</label>
                                    <input type="text" class="form-control" id="subject">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="message">Message</label>
                                <textarea class="form-control" id="message" rows="6" required></textarea>
                            </div>
                            <button type="submit" id="submitBtn" class="btn btn-primary w-100 py-3">Send Message</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Google Maps Placeholder -->
    <section class="fade-up">
        <div class="contact-map-placeholder">
            <div class="text-center">
                <i class="fas fa-map-marked-alt mb-3 contact-map-icon"></i>
                <h4 class="heading-section fs-4">Map Location</h4>
                <p class="text-muted">Interactive map can be integrated here.</p>
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

    <!-- Scripts -->
    <?php
    require_once('inc/bottom.php');
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('contactForm');
            const alertBox = document.getElementById('formAlert');
            const submitBtn = document.getElementById('submitBtn');

            if (form) {
                form.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Sending...';
                    alertBox.innerHTML = '';

                    const formData = new FormData();
                    formData.append('name', document.getElementById('name').value);
                    formData.append('email', document.getElementById('email').value);
                    formData.append('phone', document.getElementById('phone').value);
                    formData.append('subject', document.getElementById('subject').value);
                    formData.append('message', document.getElementById('message').value);

                    try {
                        const response = await fetch('ajax/submit-contact.php', {
                            method: 'POST',
                            body: formData
                        });
                        
                        const result = await response.json();
                        
                        if (result.success) {
                            alertBox.innerHTML = `<div class="alert alert-success">${result.message}</div>`;
                            form.reset();
                        } else {
                            alertBox.innerHTML = `<div class="alert alert-danger">${result.error}</div>`;
                        }
                    } catch (error) {
                        alertBox.innerHTML = `<div class="alert alert-danger">An error occurred. Please try again.</div>`;
                    } finally {
                        submitBtn.disabled = false;
                        submitBtn.textContent = 'Send Message';
                    }
                });
            }
        });
    </script>
</body>

</html>