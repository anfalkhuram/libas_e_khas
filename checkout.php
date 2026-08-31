 <?php
    require_once('inc/top.php');
    ?>

<body class="checkout-page">

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

    <!-- Checkout Content -->
    <main class="checkout-main py-5">
        <div class="container">
            <div class="row g-5">

                <!-- Left Column: Form -->
                <div class="col-lg-7">
                    <form id="checkout-form" enctype="multipart/form-data">
                        <!-- Contact Info -->
                        <section class="checkout-section mb-5">
                            <div class="d-flex justify-content-between align-items-end mb-3">
                                <h2 class="checkout-title mb-0">Contact Information</h2>
                                
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control checkout-input" placeholder="Email Address" required>
                            </div>
                        </section>

                        <!-- Shipping Address -->
                        <section class="checkout-section mb-5">
                            <h2 class="checkout-title mb-3">Shipping Address</h2>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="text" name="first_name" class="form-control checkout-input" placeholder="First Name" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="last_name" class="form-control checkout-input" placeholder="Last Name" required>
                                </div>
                                <div class="col-12">
                                    <input type="text" name="address" class="form-control checkout-input" placeholder="Address" required>
                                </div>
                                <div class="col-12">
                                    <input type="text" name="apartment" class="form-control checkout-input" placeholder="Apartment, suite, etc. (optional)">
                                </div>
                                <div class="col-md-6">
                                    <select name="country" class="form-select checkout-input" required>
                                        <option selected value="Pakistan">Pakistan</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="city" class="form-control checkout-input" placeholder="City" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="postal_code" class="form-control checkout-input" placeholder="Postal Code">
                                </div>
                                <div class="col-md-6">
                                    <input type="tel" name="phone" class="form-control checkout-input" placeholder="Phone" required>
                                </div>
                            </div>
                        </section>

                        <!-- Payment -->
                        <section class="checkout-section mb-5">
                            <h2 class="checkout-title mb-3">Payment</h2>

                            <div class="payment-methods">
                                <!-- COD Option -->
                                <div class="payment-option border p-3 mb-3 rounded" style="background-color: #f8f9fa;">
                                    <div class="form-check d-flex align-items-center">
                                        <input class="form-check-input mt-0 me-3 shadow-none payment-radio" type="radio" name="payment_method" id="payment_cod" value="COD" checked style="width: 1.25em; height: 1.25em;">
                                        <label class="form-check-label flex-grow-1 fw-medium font-body" for="payment_cod">
                                            Cash on Delivery (COD)
                                        </label>
                                    </div>
                                    <div class="payment-body text-muted small mt-2 ms-4 ps-2">
                                        Pay with cash upon delivery. Applicable within Pakistan only.
                                    </div>
                                </div>

                                <!-- Easypaisa Option -->
                                <div class="payment-option border p-3 mb-3 rounded">
                                    <div class="form-check d-flex align-items-center">
                                        <input class="form-check-input mt-0 me-3 shadow-none payment-radio" type="radio" name="payment_method" id="payment_easypaisa" value="Easypaisa" style="width: 1.25em; height: 1.25em;">
                                        <label class="form-check-label flex-grow-1 fw-medium font-body" for="payment_easypaisa">
                                            Easypaisa
                                        </label>
                                    </div>
                                </div>

                                <!-- Jazzcash Option -->
                                <div class="payment-option border p-3 mb-3 rounded">
                                    <div class="form-check d-flex align-items-center">
                                        <input class="form-check-input mt-0 me-3 shadow-none payment-radio" type="radio" name="payment_method" id="payment_jazzcash" value="Jazzcash" style="width: 1.25em; height: 1.25em;">
                                        <label class="form-check-label flex-grow-1 fw-medium font-body" for="payment_jazzcash">
                                            Jazzcash
                                        </label>
                                    </div>
                                </div>

                                <!-- Bank Transfer Option -->
                                <div class="payment-option border p-3 mb-2 rounded">
                                    <div class="form-check d-flex align-items-center">
                                        <input class="form-check-input mt-0 me-3 shadow-none payment-radio" type="radio" name="payment_method" id="payment_bank" value="Bank Transfer" style="width: 1.25em; height: 1.25em;">
                                        <label class="form-check-label flex-grow-1 fw-medium font-body" for="payment_bank">
                                            Bank Transfer
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Payment Proof -->
                            <div id="payment-proof-container" class="mt-4 d-none p-3 border rounded bg-light">
                                <h6 class="fw-bold mb-2">Upload Payment Proof</h6>
                                <p class="small text-muted mb-3">Please upload a screenshot of your successful transaction.</p>
                                <input type="file" name="payment_proof" id="payment_proof" class="form-control form-control-sm" accept="image/*">
                            </div>
                        </section>

                        <!-- Actions -->
                        <div class="checkout-actions d-flex justify-content-between align-items-center mt-4">
                            <a href="shop" class="return-link"><i class="fas fa-chevron-left me-2 small"></i>Return to shop</a>
                            <button type="submit" class="btn btn-dark btn-place-order px-5 py-3 rounded-0 text-uppercase fw-semibold tracking-wider">Place Order</button>
                        </div>
                    </form>
                </div>

                <!-- Right Column: Order Summary -->
                <div class="col-lg-5">
                    <div class="order-summary-card p-4 p-md-5 bg-white border">
                        <h3 class="order-summary-title mb-4">Order Summary</h3>

                        <div id="checkout-order-items" class="order-items mb-4">
                            <!-- Items will be dynamically injected here via JS -->
                        </div>

                        <hr class="my-4 text-muted">

                        <div class="order-totals">
                            <div class="d-flex justify-content-between mb-2 text-muted">
                                <span>Subtotal</span>
                                <span id="checkout-subtotal">PKR 0</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 text-muted">
                                <span>Shipping</span>
                                <span>Free</span>
                            </div>
                        </div>

                        <hr class="my-4 text-muted">

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="total-label fs-4 font-heading">Total</span>
                            <span id="checkout-total" class="total-price fs-3 text-gold font-heading">PKR 0</span>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </main>

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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const checkoutItemsContainer = document.getElementById('checkout-order-items');
            const checkoutSubtotalEl = document.getElementById('checkout-subtotal');
            const checkoutTotalEl = document.getElementById('checkout-total');
            const placeOrderBtn = document.querySelector('.btn-place-order');
            const checkoutForm = document.getElementById('checkout-form');
            const paymentRadios = document.querySelectorAll('.payment-radio');
            const paymentProofContainer = document.getElementById('payment-proof-container');
            const paymentProofInput = document.getElementById('payment_proof');

            const safeFormatPrice = (price) => {
                return (typeof formatPrice !== 'undefined') ? formatPrice(price) : `PKR ${price.toLocaleString()}`;
            };

            // Payment proof toggle
            paymentRadios.forEach(radio => {
                radio.addEventListener('change', (e) => {
                    if (e.target.value === 'COD') {
                        paymentProofContainer.classList.add('d-none');
                        paymentProofInput.removeAttribute('required');
                    } else {
                        paymentProofContainer.classList.remove('d-none');
                        paymentProofInput.setAttribute('required', 'required');
                    }
                });
            });

            if (!checkoutItemsContainer) return;

            const cart = JSON.parse(localStorage.getItem('libasCart')) || [];
            
            if (cart.length === 0) {
                checkoutItemsContainer.innerHTML = '<p class="text-center text-muted">Your cart is empty.</p>';
                checkoutSubtotalEl.textContent = safeFormatPrice(0);
                checkoutTotalEl.textContent = safeFormatPrice(0);
                if (placeOrderBtn) placeOrderBtn.disabled = true;
                return;
            }

            let subtotal = 0;
            checkoutItemsContainer.innerHTML = '';

            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;
                
                const itemHtml = `
                    <div class="order-item d-flex align-items-center mb-3">
                        <div class="item-image-wrapper position-relative me-3">
                            <img src="${item.image}" alt="${item.name}" class="item-image border">
                            <span class="item-quantity position-absolute top-0 start-100 translate-middle badge rounded-circle bg-dark">${item.quantity}</span>
                        </div>
                        <div class="item-details flex-grow-1">
                            <h6 class="item-name mb-0 fw-bold">${item.name}</h6>
                            <span class="item-variant text-muted small">${item.size || 'Standard'}</span>
                        </div>
                        <div class="item-price fw-medium">
                            ${safeFormatPrice(itemTotal)}
                        </div>
                    </div>
                `;
                checkoutItemsContainer.innerHTML += itemHtml;
            });

            checkoutSubtotalEl.textContent = safeFormatPrice(subtotal);
            checkoutTotalEl.textContent = safeFormatPrice(subtotal); // Total is subtotal since shipping is Free

            // Handle Form Submission
            if (checkoutForm) {
                checkoutForm.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    if (cart.length === 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Empty Cart',
                            text: 'Your cart is empty. Please add items to proceed.',
                            confirmButtonColor: '#c8a97e'
                        });
                        return;
                    }

                    const originalBtnText = placeOrderBtn.textContent;
                    placeOrderBtn.disabled = true;
                    placeOrderBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';

                    const formData = new FormData(checkoutForm);
                    formData.append('cart', JSON.stringify(cart));
                    formData.append('total_amount', subtotal);

                    try {
                        const response = await fetch('ajax/place-order.php', {
                            method: 'POST',
                            body: formData
                        });
                        
                        const result = await response.json();
                        
                        if (result.success) {
                            localStorage.removeItem('libasCart');
                            Swal.fire({
                                icon: 'success',
                                title: 'Order Placed Successfully!',
                                text: result.message || 'Your order has been received.',
                                confirmButtonColor: '#c8a97e'
                            }).then(() => {
                                window.location.href = 'index'; // Or a dedicated thank you page
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed to Place Order',
                                text: result.error || 'Please try again.',
                                confirmButtonColor: '#c8a97e'
                            });
                            placeOrderBtn.disabled = false;
                            placeOrderBtn.textContent = originalBtnText;
                        }
                    } catch (error) {
                        console.error('Error placing order:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while processing your order.',
                            confirmButtonColor: '#c8a97e'
                        });
                        placeOrderBtn.disabled = false;
                        placeOrderBtn.textContent = originalBtnText;
                    }
                });
            }
        });
    </script>
</body>

</html>