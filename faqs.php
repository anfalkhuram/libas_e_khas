<?php
$pageTitle = "Frequently Asked Questions | Libas-e-Khas";
$metaDescription = "Have questions about Libas-e-Khas? Find answers about our shipping, returns, order processing, and custom sizing for our Pakistani fashion collections.";
$schemaData = [
    "@context" => "https://schema.org",
    "@type" => "FAQPage",
    "mainEntity" => [
        [
            "@type" => "Question",
            "name" => "Do you offer international shipping?",
            "acceptedAnswer" => [
                "@type" => "Answer",
                "text" => "Yes, we ship globally! International orders typically arrive within 7-14 business days. Shipping costs are calculated at checkout based on your location."
            ]
        ],
        [
            "@type" => "Question",
            "name" => "How do I know my size?",
            "acceptedAnswer" => [
                "@type" => "Answer",
                "text" => "We provide a detailed size guide on every product page. If you are between sizes, we recommend selecting 'Custom' and providing your exact measurements at checkout."
            ]
        ],
        [
            "@type" => "Question",
            "name" => "Can I customize the color or fit?",
            "acceptedAnswer" => [
                "@type" => "Answer",
                "text" => "Absolutely. We offer color customization and bespoke tailoring. Simply select 'Custom' when adding to cart and leave a note with your specific requirements."
            ]
        ],
        [
            "@type" => "Question",
            "name" => "What is your return policy?",
            "acceptedAnswer" => [
                "@type" => "Answer",
                "text" => "We accept returns within 14 days of delivery for standard sizes, provided the item is unworn and in original condition. Custom-tailored pieces are non-refundable."
            ]
        ]
    ]
];
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

    <!-- Hero Section -->
    <section class="faq-hero fade-up">
        <div class="container">
            <p class="subtitle text-uppercase mb-2 text-gold tracking-3">Assistance &
                Guidance</p>
            <h1 class="heading-editorial mb-3">Frequently Asked Questions</h1>
            <p class="text-muted mx-auto max-w-600">Everything you need to know about our luxury bridal
                creations, bespoke customization, sizing, shipping, and order experience.</p>

            <!-- Search Input -->
            <div class="faq-search-wrapper">
                <i class="fas fa-search faq-search-icon"></i>
                <input type="text" id="faqSearchInput" class="faq-search-input"
                    placeholder="Search by topic, e.g., 'bridal customization', 'shipping', 'sizing'...">
            </div>
        </div>
    </section>

    <!-- FAQ Content Section -->
    <section class="py-5">
        <div class="container py-lg-4">

            <!-- Category Filter Tabs (Horizontally Scrollable Ribbon on Mobile) -->
            <div class="faq-filter-wrapper fade-up">
                <div class="faq-filter-scroll" id="faqFilterButtons">
                    <button class="faq-cat-btn active" data-filter="all">All Topics</button>
                    <button class="faq-cat-btn" data-filter="customization">Customization & Bridal</button>
                    <button class="faq-cat-btn" data-filter="sizing">Sizing & Tailoring</button>
                    <button class="faq-cat-btn" data-filter="shipping">Shipping & Delivery</button>
                    <button class="faq-cat-btn" data-filter="payments">Payments & Pricing</button>
                    <button class="faq-cat-btn" data-filter="returns">Returns & Alterations</button>
                    <button class="faq-cat-btn" data-filter="care">Fabric & Care</button>
                </div>
            </div>

            <!-- FAQ Accordion -->
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="accordion" id="faqAccordion">

                        <!-- Item 1: Customization & Bridal -->
                        <div class="accordion-item faq-item" data-category="customization">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                    aria-expanded="true" aria-controls="collapseOne">
                                    How do I place a custom or bespoke bridal order?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    To place a custom bespoke bridal order, you can book a virtual consultation via WhatsApp video call or
                                    visit our Lahore boutique. Our design consultants will guide you through silhouette selection,
                                    embroidery patterns (Zardozi, Dabka, Resham, French knots), color palette customization, and fabric
                                    choices. Once details are finalized and measurements received, our master artisans begin hand-crafting
                                    your heirloom piece.
                                </div>
                            </div>
                        </div>

                        <!-- Item 2: Customization & Bridal -->
                        <div class="accordion-item faq-item" data-category="customization">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Can I customize the color, embroidery, or neckline of an existing design?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes, absolute personalization is our specialty. Almost all designs in our Bridal and Couture
                                    collections can be customized in terms of base fabric, shade/color palette, neckline styling, sleeve
                                    lengths, and dupatta borders. Simply reach out with your preferences during ordering.
                                </div>
                            </div>
                        </div>

                        <!-- Item 3: Customization & Bridal -->
                        <div class="accordion-item faq-item" data-category="customization">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    How much advance time is required for bridal and couture outfits?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Because each bridal ensemble involves hundreds of hours of meticulous hand-embroidery and artisanal
                                    craftsmanship, we recommend booking bridal orders <strong>6 to 10 weeks</strong> in advance of your
                                    wedding date. Luxury Pret and Formal party wear typically require <strong>2 to 4 weeks</strong>. If
                                    you require an expedited rush order, please consult our support team for urgent availability.
                                </div>
                            </div>
                        </div>

                        <!-- Item 4: Sizing & Tailoring -->
                        <div class="accordion-item faq-item" data-category="sizing">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    How do I choose the correct size, or provide custom measurements?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    We offer standard ready-to-wear sizing from <strong>XS to XXL</strong> (refer to our detailed size
                                    guide on product details pages). For a bespoke tailored fit, you can select "Custom Stitching" during
                                    checkout and submit your specific measurements (bust, waist, hips, shoulder, armhole, shirt length,
                                    trouser length). Our tailoring masters ensure precision to your silhouette.
                                </div>
                            </div>
                        </div>

                        <!-- Item 5: Sizing & Tailoring -->
                        <div class="accordion-item faq-item" data-category="sizing">
                            <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    Do you provide custom stitching for unstitched suits?
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes! We provide complete boutique-grade stitching for unstitched outfits including custom inner
                                    linings (pure cotton silk / crepe), custom hand-piping, delicate lace inserts, handmade buttons, and
                                    tassels as pictured in the model photoshoot.
                                </div>
                            </div>
                        </div>

                        <!-- Item 6: Shipping & Delivery -->
                        <div class="accordion-item faq-item" data-category="shipping">
                            <h2 class="accordion-header" id="headingSix">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                    Do you ship internationally worldwide?
                                </button>
                            </h2>
                            <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    No, currently Libas E Khas delivers exclusively nationwide across Pakistan. We deliver to all cities,
                                    towns, and regions through reliable courier services (TCS, Leopards, and Call Courier). All orders are
                                    carefully packed in protective luxury boxes to ensure safe arrival.
                                </div>
                            </div>
                        </div>

                        <!-- Item 7: Shipping & Delivery -->
                        <div class="accordion-item faq-item" data-category="shipping">
                            <h2 class="accordion-header" id="headingSeven">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                    What are the delivery timelines and how can I track my order?
                                </button>
                            </h2>
                            <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <ul class="list-unstyled d-flex flex-column gap-2 mb-3">
                                        <li class="d-flex align-items-start gap-2">
                                            <i class="fas fa-circle-check mt-1 text-gold fs-7"></i>
                                            <div><strong>Ready-to-Wear:</strong> Delivered across Pakistan within <strong>2 to 4 business
                                                    days</strong>.</div>
                                        </li>
                                        <li class="d-flex align-items-start gap-2">
                                            <i class="fas fa-circle-check mt-1 text-gold fs-7"></i>
                                            <div><strong>Made-to-Measure & Custom Couture:</strong> Dispatched within <strong>2 to 4
                                                    weeks</strong> upon completion.</div>
                                        </li>
                                    </ul>
                                    <p class="mb-0">As soon as your package is dispatched, you will receive a tracking link via email and
                                        WhatsApp to track your delivery status in real time.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Item 8: Payments & Pricing -->
                        <div class="accordion-item faq-item" data-category="payments">
                            <h2 class="accordion-header" id="headingEight">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                    What payment methods are supported?
                                </button>
                            </h2>
                            <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p class="mb-2">We offer multiple convenient and secure payment options:</p>
                                    <ul class="list-unstyled d-flex flex-column gap-2 mb-0">
                                        <li class="d-flex align-items-start gap-2">
                                            <i class="fas fa-circle-check mt-1 text-gold fs-7"></i>
                                            <div><strong>Cash on Delivery (COD):</strong> Available for ready-to-wear orders across Pakistan.
                                            </div>
                                        </li>
                                        <li class="d-flex align-items-start gap-2">
                                            <i class="fas fa-circle-check mt-1 text-gold fs-7"></i>
                                            <div><strong>Direct Bank Transfer / EasyPaisa / JazzCash:</strong> Direct transfer to our official
                                                bank account with swift confirmation.</div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Item 9: Returns & Alterations -->
                        <div class="accordion-item faq-item" data-category="returns">
                            <h2 class="accordion-header" id="headingNine">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                                    What is your policy on returns, exchanges, or alterations?
                                </button>
                            </h2>
                            <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <ul class="list-unstyled d-flex flex-column gap-2 mb-0">
                                        <li class="d-flex align-items-start gap-2">
                                            <i class="fas fa-circle-check mt-1 text-gold fs-7"></i>
                                            <div><strong>Ready-to-Wear:</strong> Standard un-altered pret garments can be exchanged within
                                                <strong>7 days</strong> of delivery if unused, unwashed, with all original tags attached.
                                            </div>
                                        </li>
                                        <li class="d-flex align-items-start gap-2">
                                            <i class="fas fa-circle-check mt-1 text-gold fs-7"></i>
                                            <div><strong>Custom & Bridal Pieces:</strong> As custom pieces are hand-made specifically to your
                                                measurements and chosen specifications, they are non-refundable. However, we provide
                                                complimentary alteration assistance if any minor fitting adjustments are required.</div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Item 10: Fabric & Care -->
                        <div class="accordion-item faq-item" data-category="care">
                            <h2 class="accordion-header" id="headingTen">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                                    What fabrics are used and how should I care for embellished outfits?
                                </button>
                            </h2>
                            <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Libas E Khas exclusively uses 100% pure authentic fabrics, including pure Raw Silk, Pure Katan Silk,
                                    Organza, French Chiffon, Velvet, and Jacquard. All hand-embellished zardozi, dabka, and crystal pieces
                                    must be <strong>strictly dry-cleaned only</strong>. Store outfits in breathable muslin or fabric
                                    garment covers away from damp environments or direct sunlight.
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Empty Search State -->
                    <div id="faqNoResults" class="text-center py-5 d-none">
                        <i class="fas fa-question-circle text-muted mb-3 faq-noresults-icon"></i>
                        <h4 class="heading-section fs-4">No Matching Questions Found</h4>
                        <p class="text-muted">Try searching with different keywords or contact our team directly below.</p>
                    </div>

                    <!-- Still Have Questions Support Card -->
                    <div class="faq-support-card fade-up">
                        <h3 class="heading-section fs-3 mb-2">Still Have Questions?</h3>
                        <p class="text-muted mb-4 mx-auto max-w-500">Our dedicated bridal stylists and customer care
                            specialists are available to guide you through every detail.</p>
                        <div class="d-flex flex-wrap justify-content-center gap-3">
                            <a href="contact" class="btn btn-primary px-4 py-3">Send a Message</a>
                            <a href="https://wa.me/+923227939492" target="_blank" class="btn btn-outline px-4 py-3"><i
                                    class="fab fa-whatsapp me-2"></i> Chat on WhatsApp</a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <!-- Cart Offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas" aria-labelledby="cartOffcanvasLabel">
        <div class="offcanvas-header border-bottom border-light">
            <h5 class="offcanvas-title font-heading" id="cartOffcanvasLabel">Your Bag</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column bg-ivory">
            <div id="cart-items" class="flex-grow-1 overflow-auto pe-2"></div>
            <div class="cart-footer mt-4 border-top pt-3">
                <div class="d-flex justify-content-between mb-3">
                    <span class="font-weight-bold font-body fw-medium">Subtotal</span>
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
    <script src="js/faqs.js"></script>
</body>

</html>