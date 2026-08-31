<?php
require_once('inc/db.php');

$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$productName = "Product Not Found";

if ($productId > 0) {
    $stmt = $conn->prepare("
        SELECT p.*, c.name as category_name, sc.name as sub_category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        LEFT JOIN sub_categories sc ON p.sub_category_id = sc.id 
        WHERE p.id = ?
    ");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $product = $result->fetch_assoc();
        
        $productName = htmlspecialchars_decode($product['name']);
        $productDesc = htmlspecialchars_decode($product['shortDescription'] ?? $product['description']);
        // Fallback description
        if (empty(trim($productDesc))) {
            $productDesc = "Discover $productName at Libas-e-Khas. Premium quality and elegant design.";
        }
        
        $pageTitle = "$productName | Libas-e-Khas";
        $metaDescription = substr(strip_tags($productDesc), 0, 155);
        $ogImage = $product['main_image'];
        
        $availability = strtolower($product['availability']) === 'out of stock' ? 'https://schema.org/OutOfStock' : 'https://schema.org/InStock';
        $price = $product['sale'] ? floatval($product['salePrice']) : floatval($product['price']);
        $sku = 'LK-' . str_pad($productId, 3, '0', STR_PAD_LEFT);
        
        // Product Schema
        $productSchema = [
            "@context" => "https://schema.org",
            "@type" => "Product",
            "name" => $productName,
            "image" => $ogImage,
            "description" => $metaDescription,
            "sku" => $sku,
            "brand" => [
                "@type" => "Brand",
                "name" => "Libas-e-Khas"
            ],
            "offers" => [
                "@type" => "Offer",
                "url" => "https://" . $_SERVER['HTTP_HOST'] . "/product-details.php?id=" . $productId,
                "priceCurrency" => "PKR",
                "price" => $price,
                "availability" => $availability,
                "itemCondition" => "https://schema.org/NewCondition"
            ]
        ];
        
        // Breadcrumb Schema
        $categoryName = $product['category_name'] ?? 'Shop';
        $breadcrumbSchema = [
            "@context" => "https://schema.org",
            "@type" => "BreadcrumbList",
            "itemListElement" => [
                [
                    "@type" => "ListItem",
                    "position" => 1,
                    "name" => "Home",
                    "item" => "https://" . $_SERVER['HTTP_HOST'] . "/"
                ],
                [
                    "@type" => "ListItem",
                    "position" => 2,
                    "name" => "Shop",
                    "item" => "https://" . $_SERVER['HTTP_HOST'] . "/shop.php"
                ],
                [
                    "@type" => "ListItem",
                    "position" => 3,
                    "name" => $categoryName,
                    "item" => "https://" . $_SERVER['HTTP_HOST'] . "/shop.php?cat=" . urlencode($categoryName)
                ],
                [
                    "@type" => "ListItem",
                    "position" => 4,
                    "name" => $productName
                ]
            ]
        ];
        
        $schemaData = [$productSchema, $breadcrumbSchema];
    }
    $stmt->close();
}

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

    <!-- Breadcrumb -->
    <div class="breadcrumb-container py-3 bg-nude">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 pd-breadcrumb" id="pd-breadcrumb">
                    <li class="breadcrumb-item"><a href="index" class="text-dark text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item"><a href="shop" class="text-dark text-decoration-none">Shop</a></li>
                    <li class="breadcrumb-item active text-muted" aria-current="page" id="bd-current">Product</li>
                </ol>
            </nav>
        </div>
    </div>

    <div id="pd-error-container" class="container py-5 text-center d-none min-vh-50">
        <h2 class="heading-editorial mb-4">Product Not Found</h2>
        <p class="text-muted mb-4">The product you are looking for does not exist or is no longer available.</p>
        <a href="shop.html" class="btn btn-primary px-4 py-2">Back to Shop</a>
    </div>

    <!-- Product Details Section -->
    <section class="py-5" id="product-detail-content">
        <div class="container">
            <div class="row g-5">

                <!-- Left: Image Gallery -->
                <div class="col-lg-7">
                    <div class="row g-3 flex-column-reverse flex-lg-row h-100 pd-gallery-row">
                        <!-- Thumbnails -->
                        <div class="col-lg-2 d-flex flex-row flex-lg-column gap-3 overflow-auto pd-thumbnail-col">
                            <div id="pd-thumbnails" class="d-flex flex-row flex-lg-column gap-3 w-100">
                                <!-- Rendered by JS -->
                            </div>
                        </div>
                        <!-- Main Image -->
                        <div class="col-lg-10 position-relative">
                            <div class="main-img-container overflow-hidden position-relative w-100 h-100 pd-main-img-box" id="pd-main-img-container" style="border-radius: 0;">
                                <img src="" id="pd-main-img" class="img-fluid w-100 h-100 object-fit-cover pd-main-img" alt="Product Main Image" fetchpriority="high" width="600" height="800">
                                <button class="btn pd-zoom-btn bg-white shadow-sm" type="button" aria-label="Zoom Image" style="border-radius: 0; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; bottom: 15px; right: 15px; position: absolute;">
                                    <i class="fas fa-search-plus text-dark"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Info -->
                <div class="col-lg-5">
                    <div class="product-info-panel pe-lg-4">
                        <div class="d-inline-block px-3 py-1 bg-light text-muted fw-medium fs-8 mb-3 rounded-0 text-uppercase" id="pd-category" style="letter-spacing: 0.05em;">Category</div>
                        <h1 id="pd-name" class="heading-editorial mb-2 fs-2 fw-semibold pd-title" style="letter-spacing: -0.02em;"><?php echo htmlspecialchars($productName); ?></h1>

                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="text-gold fs-7" id="pd-stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <a href="#reviews-tab-pane" class="text-dark fw-medium text-decoration-none fs-7 font-body"><span id="pd-reviews-count">0</span> reviews</a>
                        </div>

                        <div class="d-flex align-items-end gap-3 mb-3">
                            <div class="fs-2 fw-semibold font-body text-dark" id="pd-price">$0</div>
                            <div class="d-inline-block px-2 py-1 bg-dark text-white fw-medium fs-8 mb-2 rounded-0" id="pd-discount-badge" style="display: none;">SALE</div>
                        </div>

                        <div class="text-muted mb-4 fs-6 d-flex align-items-start gap-2">
                            <i class="fas fa-tags mt-1"></i>
                            <span id="pd-collection-tag">Collection Name</span>
                        </div>

                        <p id="pd-short-desc" class="text-muted mb-4 pb-2 border-bottom pd-short-desc lh-lg">
                            Product short description...
                        </p>

                        <!-- Specifications -->
                        <div class="d-flex flex-wrap gap-4 text-muted fs-7 mb-4 pb-4 border-bottom">
                            <div class="d-flex align-items-center gap-2"><i class="fas fa-layer-group fs-6 text-dark"></i> <span id="pd-info-fabric">Fabric</span></div>
                            <div class="d-flex align-items-center gap-2"><i class="fas fa-puzzle-piece fs-6 text-dark"></i> <span id="pd-info-pieces">Pieces</span></div>
                            <div class="d-flex align-items-center gap-2"><i class="fas fa-box fs-6 text-dark"></i> <span id="pd-availability">In Stock</span></div>
                        </div>

                        <!-- Variations Dynamic Container -->
                        <div id="pd-variations-container" class="d-none">
                            
                            <!-- Color Selector -->
                            <div class="mb-4" id="pd-color-section">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="text-dark fw-medium fs-7">Color: <strong id="pd-selected-color-name"></strong></span>
                                </div>
                                <div class="d-flex flex-wrap gap-2" id="pd-colors">
                                    <!-- Rendered by JS -->
                                </div>
                            </div>

                            <!-- Option Selector -->
                            <div class="mb-4" id="pd-option-section">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="text-dark fw-medium fs-7">Option: <strong id="pd-selected-option-name"></strong></span>
                                </div>
                                <div class="d-flex flex-column gap-2" id="pd-options">
                                    <!-- Rendered by JS -->
                                </div>
                            </div>

                            <!-- Size Selector -->
                            <div class="mb-4" id="pd-size-section">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-dark fw-medium fs-7">Size: <strong id="pd-selected-size-name"></strong></span>
                                    <button class="btn btn-link p-0 text-muted text-decoration-none fs-8 fw-medium" data-bs-toggle="modal" data-bs-target="#sizeGuideModal"><i class="fas fa-ruler-horizontal me-1"></i> Size Guide</button>
                                </div>
                                <div class="d-flex flex-wrap gap-2" id="pd-sizes">
                                    <!-- JS populated -->
                                </div>
                            </div>
                            
                            <!-- Selected Variation Info -->
                            <div id="pd-variation-error" class="alert alert-danger rounded-0 d-none py-2 mb-4" style="font-size: 0.85rem;">
                                This combination is currently unavailable.
                            </div>
                            <input type="hidden" id="pd-selected-variation-id" value="">
                        </div>

                        <!-- Fallback legacy selectors (will be hidden if variations exist) -->
                        <div id="pd-legacy-container">
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-dark fw-medium fs-7">Select Size</span>
                                </div>
                                <div class="d-flex flex-wrap gap-2" id="pd-legacy-sizes"></div>
                            </div>
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="text-dark fw-medium fs-7">Select Color</span>
                                </div>
                                <select class="form-select rounded-0 border-dark shadow-none w-100" id="pd-legacy-color" style="height: 48px;">
                                    <option value="As Pictured" selected>As Pictured</option>
                                    <option value="Custom">Custom Color (Add note at checkout)</option>
                                </select>
                            </div>
                        </div>


                        <!-- Actions -->
                        <div class="row g-3 mt-4 pt-2">
                            <div class="col-4">
                                <div class="quantity-selector d-flex align-items-center border h-100 pd-qty-selector" style="border-radius: 0;">
                                    <button class="btn px-2 py-2 border-0 shadow-none h-100" type="button" id="pd-qty-minus"><i class="fas fa-minus text-muted fs-8"></i></button>
                                    <input type="number" id="pd-qty" class="form-control text-center border-0 p-0 shadow-none fw-medium h-100 bg-transparent" value="1" min="1">
                                    <button class="btn px-2 py-2 border-0 shadow-none h-100" type="button" id="pd-qty-plus"><i class="fas fa-plus text-muted fs-8"></i></button>
                                </div>
                            </div>
                            <div class="col-8">
                                <button class="btn btn-primary w-100 py-3 fw-semibold fs-6 h-100" id="pd-add-to-cart" style="border-radius: 0;">
                                    Buy Now
                                </button>
                            </div>
                            <div class="col-12 mt-2">
                                <a href="https://wa.me/+923227939492" target="_blank" class="btn btn-outline w-100 py-3 fw-semibold fs-6 d-flex align-items-center justify-content-center gap-2" id="pd-whatsapp-btn" style="border-radius: 0; border-color: #dee2e6;">
                                    <i class="fab fa-whatsapp text-success fs-5"></i> Chat on Whatsapp
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Promotional Marquee -->
    <div class="border-top border-bottom" style="height: 140px; background-color: #383838; display: flex; align-items: center; overflow: hidden;">
        <marquee scrollamount="12" style="font-size: 2.5rem; font-family: Tahoma, sans-serif; font-weight: 700; color: #ffffff; letter-spacing: 2px; text-transform: uppercase;">
            Rs. 999 off on advance payment &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rs. 999 off on advance payment &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rs. 999 off on advance payment &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rs. 999 off on advance payment
        </marquee>
    </div>

    <!-- Tabs Section -->
    <section class="py-5 bg-white border-top" id="pd-tabs-section">
        <div class="container">
            <ul class="nav nav-tabs border-bottom mb-5 gap-2 gap-md-4" id="productTabs" role="tablist" style="border-bottom-width: 2px !important;">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active border-0 bg-transparent text-dark fw-semibold pb-3 pd-tab-btn fs-6 position-relative" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc-tab-pane" type="button" role="tab" style="padding-left: 0; padding-right: 0;">Overview</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link border-0 bg-transparent text-muted fw-semibold pb-3 pd-tab-btn fs-6 position-relative" id="additional-tab" data-bs-toggle="tab" data-bs-target="#additional-tab-pane" type="button" role="tab" style="padding-left: 0; padding-right: 0;">Additional Info</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link border-0 bg-transparent text-muted fw-semibold pb-3 pd-tab-btn fs-6 position-relative" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping-tab-pane" type="button" role="tab" style="padding-left: 0; padding-right: 0;">Shipping & Returns</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link border-0 bg-transparent text-muted fw-semibold pb-3 pd-tab-btn fs-6 position-relative" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews-tab-pane" type="button" role="tab" style="padding-left: 0; padding-right: 0;">Reviews (<span id="pd-review-tab-count">0</span>)</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <!-- Overview Tab -->
                <div class="tab-pane fade show active text-muted lh-lg" id="desc-tab-pane" role="tabpanel" tabindex="0">
                    <div class="row align-items-center">
                        <div class="col-lg-7 pe-lg-5">
                            <p id="pd-full-desc" class="mb-5 fs-6 text-dark" style="opacity: 0.8;">Loading description...</p>
                            <div class="row" id="pd-features-list">
                                <!-- Rendered by JS -->
                            </div>
                        </div>
                        <div class="col-lg-5 mt-4 mt-lg-0">
                            <img src="" id="pd-overview-img" class="img-fluid rounded-0 w-100" alt="Product Overview" style="border-radius: 0 !important; box-shadow: var(--shadow-subtle); aspect-ratio: 16/9; object-fit: cover;" loading="lazy" decoding="async" width="800" height="450">
                        </div>
                    </div>
                    
                    <!-- Appended Size Guide for Description -->
                    <div class="row mt-5 pt-4 border-top">
                        <div class="col-12 col-md-10 mx-auto">
                            <h4 class="text-center fw-bold text-dark mb-4 heading-editorial letter-spacing-1">SIZE GUIDE</h4>
                            <div class="table-responsive border border-dark">
                                <table class="table table-striped text-center align-middle fs-6 fw-medium mb-0" style="--bs-table-striped-bg: rgba(0,0,0,0.05);">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th class="bg-dark text-white py-3">SIZE (inch)</th>
                                            <th class="bg-dark text-white py-3">S</th>
                                            <th class="bg-dark text-white py-3">M</th>
                                            <th class="bg-dark text-white py-3">L</th>
                                            <th class="bg-dark text-white py-3">XL</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-dark">
                                        <tr>
                                            <th class="text-dark fw-bold">SHIRT-LENGTH</th>
                                            <td>39</td>
                                            <td>39</td>
                                            <td>39.5</td>
                                            <td>39.5</td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold">SLEEVES-LENGTH</th>
                                            <td>21</td>
                                            <td>21</td>
                                            <td>21</td>
                                            <td>21</td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold">ARM-HOLE</th>
                                            <td>7.5</td>
                                            <td>8.5</td>
                                            <td>9.5</td>
                                            <td>10</td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold">SHOULDER</th>
                                            <td>14.5</td>
                                            <td>15.5</td>
                                            <td>16.5</td>
                                            <td>17</td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold">BUST</th>
                                            <td>19</td>
                                            <td>21</td>
                                            <td>23</td>
                                            <td>25</td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold">WAIST</th>
                                            <td>19</td>
                                            <td>21</td>
                                            <td>23</td>
                                            <td>25</td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold">HIP</th>
                                            <td>22</td>
                                            <td>24</td>
                                            <td>26</td>
                                            <td>27</td>
                                        </tr>
                                        <tr>
                                            <th class="text-dark fw-bold">DAMAN</th>
                                            <td>22</td>
                                            <td>24</td>
                                            <td>26</td>
                                            <td>26</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <p class="text-muted text-center mt-3 fs-7">Note:- The size might vary by roughly 1 inch, either more or less.</p>
                        </div>
                    </div>
                </div>
                <!-- Additional Info Tab -->
                <div class="tab-pane fade text-muted" id="additional-tab-pane" role="tabpanel" tabindex="0">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <h5 class="text-dark mb-3 fw-semibold">Product Details</h5>
                            <ul class="list-unstyled lh-lg">
                                <li><i class="fas fa-check text-muted me-2" style="font-size: 0.8rem;"></i> Fabric: <span id="tab-info-fabric">N/A</span></li>
                                <li><i class="fas fa-check text-muted me-2" style="font-size: 0.8rem;"></i> Collection: <span id="tab-info-collection">N/A</span></li>
                                <li><i class="fas fa-check text-muted me-2" style="font-size: 0.8rem;"></i> Tags: <span id="tab-info-tags">N/A</span></li>
                            </ul>
                        </div>
                        <div class="col-md-6 mb-4">
                            <h5 class="text-dark mb-3 fw-semibold">Care Instructions</h5>
                            <ul class="list-unstyled lh-lg">
                                <li><i class="fas fa-check text-muted me-2" style="font-size: 0.8rem;"></i> Dry Clean Only</li>
                                <li><i class="fas fa-check text-muted me-2" style="font-size: 0.8rem;"></i> Do Not Bleach</li>
                                <li><i class="fas fa-check text-muted me-2" style="font-size: 0.8rem;"></i> Iron at Low Temperature</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Shipping Tab -->
                <div class="tab-pane fade text-muted text-center" id="shipping-tab-pane" role="tabpanel" tabindex="0">
                    <div class="bg-light p-5 rounded-0">
                        <i class="fas fa-shipping-fast fs-1 text-muted mb-3"></i>
                        <p class="mb-0">Free shipping on all orders over 10,000 PKR. Delivery within 3-5 business days.</p>
                    </div>
                </div>
                <div class="tab-pane fade" id="reviews-tab-pane" role="tabpanel" tabindex="0">
                    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                        <h4 class="mb-0 fs-5 font-heading">Customer Reviews</h4>
                        <button class="btn btn-outline-dark rounded-0 px-4" data-bs-toggle="modal" data-bs-target="#reviewModal">Write a Review</button>
                    </div>
                    <div id="pd-reviews-container">
                        <!-- Reviews injected by JS -->
                    </div>
                    <div class="text-center mt-4">
                        <button class="btn btn-outline-dark px-5 rounded-0 d-none" id="pd-see-more-reviews">See More</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products -->
    <section class="py-5 bg-ivory" id="pd-related-section">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h2 class="fs-4 fw-semibold text-dark m-0">You May Also Like</h2>
                <a href="shop.html" class="text-dark fw-medium text-decoration-none d-flex align-items-center gap-2">View All <i class="fas fa-arrow-right fs-8"></i></a>
            </div>
            <div class="row" id="pd-related-grid">
                <!-- Rendered by JS -->
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

    <!-- Gallery Modal -->
    <div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen modal-dialog-centered">
            <div class="modal-content bg-dark border-0">
                <div class="modal-body p-0 position-relative d-flex align-items-center justify-content-center">
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-4 z-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    <button class="btn text-white position-absolute start-0 top-50 translate-middle-y ms-4 fs-2 z-3" id="gallery-prev" aria-label="Previous Image"><i class="fas fa-chevron-left"></i></button>
                    <img src="" id="gallery-modal-img" class="img-fluid h-100 object-fit-contain" alt="Gallery Zoom">
                    <button class="btn text-white position-absolute end-0 top-50 translate-middle-y me-4 fs-2 z-3" id="gallery-next" aria-label="Next Image"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Size Guide Modal -->
    <div class="modal fade" id="sizeGuideModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title heading-section fs-4">Size Guide</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive border border-dark">
                        <table class="table table-striped text-center align-middle fs-6 fw-medium mb-0" style="--bs-table-striped-bg: rgba(0,0,0,0.05);">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th class="bg-dark text-white py-3">SIZE (inch)</th>
                                    <th class="bg-dark text-white py-3">S</th>
                                    <th class="bg-dark text-white py-3">M</th>
                                    <th class="bg-dark text-white py-3">L</th>
                                    <th class="bg-dark text-white py-3">XL</th>
                                </tr>
                            </thead>
                            <tbody class="text-dark">
                                <tr>
                                    <th class="text-dark fw-bold">SHIRT-LENGTH</th>
                                    <td>39</td>
                                    <td>39</td>
                                    <td>39.5</td>
                                    <td>39.5</td>
                                </tr>
                                <tr>
                                    <th class="text-dark fw-bold">SLEEVES-LENGTH</th>
                                    <td>21</td>
                                    <td>21</td>
                                    <td>21</td>
                                    <td>21</td>
                                </tr>
                                <tr>
                                    <th class="text-dark fw-bold">ARM-HOLE</th>
                                    <td>7.5</td>
                                    <td>8.5</td>
                                    <td>9.5</td>
                                    <td>10</td>
                                </tr>
                                <tr>
                                    <th class="text-dark fw-bold">SHOULDER</th>
                                    <td>14.5</td>
                                    <td>15.5</td>
                                    <td>16.5</td>
                                    <td>17</td>
                                </tr>
                                <tr>
                                    <th class="text-dark fw-bold">BUST</th>
                                    <td>19</td>
                                    <td>21</td>
                                    <td>23</td>
                                    <td>25</td>
                                </tr>
                                <tr>
                                    <th class="text-dark fw-bold">WAIST</th>
                                    <td>19</td>
                                    <td>21</td>
                                    <td>23</td>
                                    <td>25</td>
                                </tr>
                                <tr>
                                    <th class="text-dark fw-bold">HIP</th>
                                    <td>22</td>
                                    <td>24</td>
                                    <td>26</td>
                                    <td>27</td>
                                </tr>
                                <tr>
                                    <th class="text-dark fw-bold">DAMAN</th>
                                    <td>22</td>
                                    <td>24</td>
                                    <td>26</td>
                                    <td>26</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <p class="text-muted text-center mt-3 fs-7">Note:- The size might vary by roughly 1 inch, either more or less.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Write Review Modal -->
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title heading-section fs-4">Write a Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="review-form">
                        <div class="mb-3">
                            <label for="reviewName" class="form-label font-body fs-6">Name</label>
                            <input type="text" class="form-control rounded-0" id="reviewName" required>
                        </div>
                        <div class="mb-3">
                            <label for="reviewEmail" class="form-label font-body fs-6">Email address</label>
                            <input type="email" class="form-control rounded-0" id="reviewEmail" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-body fs-6">Rating</label>
                            <div class="text-gold fs-5 cursor-pointer" id="reviewRatingStars">
                                <i class="far fa-star rating-star" data-rating="1"></i>
                                <i class="far fa-star rating-star" data-rating="2"></i>
                                <i class="far fa-star rating-star" data-rating="3"></i>
                                <i class="far fa-star rating-star" data-rating="4"></i>
                                <i class="far fa-star rating-star" data-rating="5"></i>
                            </div>
                            <input type="hidden" id="reviewRatingValue" value="0" required>
                        </div>
                        <div class="mb-4">
                            <label for="reviewText" class="form-label font-body fs-6">Your Review</label>
                            <textarea class="form-control rounded-0" id="reviewText" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-dark w-100 rounded-0 py-3 font-body fw-medium tracking-wide">SUBMIT REVIEW</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- bottom Scripts -->
    <?php
    require_once('inc/bottom.php');
    ?>
    <script src="js/product-details.js?v=<?php echo time(); ?>"></script>
</body>

</html>
