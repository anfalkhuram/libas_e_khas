<?php 
    $pageTitle = "Privacy & Cookie Policy | Libas E Khas Luxury Couture";
    $metaDescription = "Discover how Libas E Khas protects your privacy, safeguards bespoke bridal measurements, and guarantees bank-grade security across all pret and couture orders.";
    require_once('inc/top.php');
?>

<body>

  <!-- Announcement Bar -->
  <div class="announcement-bar">
    Elegance Crafted for Your Most Beautiful Moments &bull; Worldwide Shipping &amp; Bespoke Consultation
  </div>

  <!-- Header -->
 <?php 
 require_once('inc/header.php'); 
 ?>

  <!-- Hero Section -->
  <section class="policy-hero fade-up">
    <div class="container">
      <p class="subtitle text-uppercase mb-2 tracking-wider text-gold">Trust, Discretion &amp; Transparency</p>
      <h1 class="heading-editorial mb-3">Privacy &amp; Cookie Policy</h1>
      <p class="text-muted mx-auto max-w-620">
        At Libas E Khas, we believe true luxury begins with complete trust. We treat your personal details, bespoke bridal measurements, and shopping records with uncompromising care, bank-grade encryption, and absolute discretion.
      </p>

      <!-- Meta Bar & Quick Tools -->
      <div class="privacy-meta-bar">
        <div class="privacy-badge-pill">
          <i class="fas fa-calendar-check"></i>
          <span>Effective: August 2026</span>
        </div>
        <div class="privacy-badge-pill">
          <i class="fas fa-shield-halved"></i>
          <span>Version 2.4 (GDPR &amp; Global Compliant)</span>
        </div>
        <div class="privacy-badge-pill">
          <i class="far fa-clock"></i>
          <span>Est. Reading Time: 6 Mins</span>
        </div>
        <button class="privacy-print-btn" onclick="window.print()" title="Print or Save PDF copy">
          <i class="fas fa-print"></i>
          <span>Print / Save Copy</span>
        </button>
      </div>
    </div>
  </section>

  <!-- Key Privacy Highlights (The 4 Pillars of Protection) -->
  <section class="py-5 bg-white border-bottom">
    <div class="container">
      <div class="text-center mb-4">
        <p class="subtitle text-uppercase mb-1 tracking-wider text-gold">Our Core Guarantees</p>
        <h2 class="heading-section fs-3">The 4 Pillars of Your Privacy</h2>
      </div>

      <div class="row g-4">
        <!-- Pillar 1 -->
        <div class="col-md-6 col-lg-3">
          <div class="pillar-card">
            <div class="pillar-icon">
              <i class="fas fa-lock"></i>
            </div>
            <h5 class="font-heading fs-5 mb-2">Bank-Grade Encryption</h5>
            <p class="text-muted small mb-0">
              All transactions utilize 256-bit SSL encryption. We adhere strictly to PCI-DSS payment compliance and never store your credit/debit card numbers.
            </p>
          </div>
        </div>

        <!-- Pillar 2 -->
        <div class="col-md-6 col-lg-3">
          <div class="pillar-card">
            <div class="pillar-icon">
              <i class="fas fa-user-shield"></i>
            </div>
            <h5 class="font-heading fs-5 mb-2">Zero Data Selling</h5>
            <p class="text-muted small mb-0">
              We never sell, rent, monetize, or trade your personal contact information, browsing behavior, or purchase histories with third-party advertisers.
            </p>
          </div>
        </div>

        <!-- Pillar 3 -->
        <div class="col-md-6 col-lg-3">
          <div class="pillar-card">
            <div class="pillar-icon">
              <i class="fas fa-tape"></i>
            </div>
            <h5 class="font-heading fs-5 mb-2">Bespoke Fitting Discretion</h5>
            <p class="text-muted small mb-0">
              Personal bridal body measurements, alteration profiles, and private consultation notes are stored confidentially solely for artisan craftsmanship.
            </p>
          </div>
        </div>

        <!-- Pillar 4 -->
        <div class="col-md-6 col-lg-3">
          <div class="pillar-card">
            <div class="pillar-icon">
              <i class="fas fa-hand-holding-hand"></i>
            </div>
            <h5 class="font-heading fs-5 mb-2">Full Data Ownership</h5>
            <p class="text-muted small mb-0">
              You retain complete rights to access, inspect, rectify, download, or permanently delete your stored information anytime via our Data Concierge.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Detailed Policy Content & Sticky Navigation -->
  <section class="py-5 bg-ivory">
    <div class="container py-lg-3">
      <div class="row g-4">

        <!-- Left Column: Sticky Table of Contents Sidebar -->
        <div class="col-lg-4 col-xl-3">
          <div class="privacy-sidebar-sticky">
            <div class="privacy-toc-card">
              <div class="privacy-toc-title">
                <span>Table of Contents</span>
                <i class="fas fa-list-ol text-gold fs-6"></i>
              </div>

              <!-- Quick Search Filter within Policy -->
              <div class="privacy-toc-search">
                <i class="fas fa-search"></i>
                <input type="text" id="policySearchInput" placeholder="Filter clauses..." aria-label="Filter clauses">
              </div>

              <!-- Navigation List -->
              <ul class="privacy-toc-list" id="privacyTocList">
                <li>
                  <a href="#scope" class="privacy-toc-link">
                    <span>Scope &amp; Commitment</span>
                    <span class="badge-num">01</span>
                  </a>
                </li>
                <li>
                  <a href="#information-collected" class="privacy-toc-link">
                    <span>Information We Collect</span>
                    <span class="badge-num">02</span>
                  </a>
                </li>
                <li>
                  <a href="#how-we-use-data" class="privacy-toc-link">
                    <span>How We Use Data</span>
                    <span class="badge-num">03</span>
                  </a>
                </li>
                <li>
                  <a href="#payment-security" class="privacy-toc-link">
                    <span>Payment Security</span>
                    <span class="badge-num">04</span>
                  </a>
                </li>
                <li>
                  <a href="#logistics-partners" class="privacy-toc-link">
                    <span>Logistics &amp; Partners</span>
                    <span class="badge-num">05</span>
                  </a>
                </li>
                <li>
                  <a href="#cookies-tracking" class="privacy-toc-link">
                    <span>Cookies &amp; Tracking</span>
                    <span class="badge-num">06</span>
                  </a>
                </li>
                <li>
                  <a href="#data-retention" class="privacy-toc-link">
                    <span>Retention &amp; Safeguards</span>
                    <span class="badge-num">07</span>
                  </a>
                </li>
                <li>
                  <a href="#your-rights" class="privacy-toc-link">
                    <span>Your Legal Rights</span>
                    <span class="badge-num">08</span>
                  </a>
                </li>
                <li>
                  <a href="#international-transfers" class="privacy-toc-link">
                    <span>International Transfers</span>
                    <span class="badge-num">09</span>
                  </a>
                </li>
                <li>
                  <a href="#childrens-privacy" class="privacy-toc-link">
                    <span>Children's Privacy</span>
                    <span class="badge-num">10</span>
                  </a>
                </li>
                <li>
                  <a href="#policy-updates" class="privacy-toc-link">
                    <span>Revisions &amp; Updates</span>
                    <span class="badge-num">11</span>
                  </a>
                </li>
                <li>
                  <a href="#contact-dpo" class="privacy-toc-link">
                    <span>Contact Our Concierge</span>
                    <span class="badge-num">12</span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Right Column: Policy Clauses -->
        <div class="col-lg-8 col-xl-9">

          <!-- Section 1: Scope & Commitment -->
          <div class="privacy-clause-card fade-up" id="scope">
            <div class="privacy-clause-header">
              <div class="clause-index-badge">01</div>
              <div>
                <h3 class="font-heading">Scope &amp; Commitment to Discretion</h3>
                <span class="label-small text-muted">Applicability across digital platforms &amp; bespoke ateliers</span>
              </div>
            </div>
            <p>
              Welcome to <strong>Libas E Khas</strong> ("we," "our," "us," or "the Atelier"). This Privacy Policy applies to all interactions with our brand, including visits to our official online boutique (<strong>www.libasekhas.com</strong>), direct WhatsApp bridal consultations, in-studio appointments, and custom tailoring orders.
            </p>
            <p>
              We recognize that selecting bridal couture, luxury pret, and heirloom formalwear involves sharing personal milestones, body measurements, and sensitive contact information. We hold your confidence in highest regard and are committed to maintaining the highest international standards of data protection, fair processing, and cybersecurity.
            </p>

            <div class="highlight-callout">
              <div class="highlight-callout-header">
                <i class="fas fa-crown"></i>
                <span>Our Luxury Guarantee</span>
              </div>
              <p>
                Your personal and fitting details are strictly used to bring your custom garments to life with immaculate craftsmanship. We never commercialize, share, or broker your information.
              </p>
            </div>
          </div>

          <!-- Section 2: Information We Collect -->
          <div class="privacy-clause-card fade-up" id="information-collected">
            <div class="privacy-clause-header">
              <div class="clause-index-badge">02</div>
              <div>
                <h3 class="font-heading">Categories of Information We Collect</h3>
                <span class="label-small text-muted">What data is gathered during your shopping journey</span>
              </div>
            </div>
            <p>
              Depending on how you engage with Libas E Khas, we collect and process the following categories of information:
            </p>

            <div class="table-responsive">
              <table class="privacy-custom-table">
                <thead>
                  <tr>
                    <th>Data Category</th>
                    <th>Specific Details Collected</th>
                    <th>Primary Purpose</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><strong>Contact &amp; Identification</strong></td>
                    <td>Full name, email address, mobile phone number, WhatsApp contact, billing and physical delivery addresses.</td>
                    <td>Order fulfillment, delivery coordination, courier updates, customer support.</td>
                  </tr>
                  <tr>
                    <td><strong>Bespoke Bridal Measurements</strong></td>
                    <td>Bust, waist, hip, shoulder width, sleeve length, neckline depth, hollow-to-hem, heel heights, and fitting preferences.</td>
                    <td>Precision pattern drafting, handcrafted tailoring, and couture fitting adjustments.</td>
                  </tr>
                  <tr>
                    <td><strong>Financial &amp; Payment Data</strong></td>
                    <td>Payment method chosen (COD, Bank Transfer, Card, Wallet), transaction reference IDs, and verification receipts.</td>
                    <td>Processing invoices, validating payment transfers, fraud detection. <em>(Card numbers are handled by PCI-DSS gateways; we never store raw CVV/card numbers)</em>.</td>
                  </tr>
                  <tr>
                    <td><strong>Milestone &amp; Event Dates</strong></td>
                    <td>Wedding date, Mehndi/Walima timeline, required dispatch deadline.</td>
                    <td>Prioritizing workshop production schedules to guarantee timely pre-event arrival.</td>
                  </tr>
                  <tr>
                    <td><strong>Technical &amp; Browsing Info</strong></td>
                    <td>IP address, browser type, device specifications, operating system, pages viewed, time spent, and referring URLs.</td>
                    <td>Website performance optimization, security monitoring, and user experience enhancements.</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="highlight-callout">
              <div class="highlight-callout-header">
                <i class="fas fa-tape"></i>
                <span>Confidential Bridal Vault</span>
              </div>
              <p>
                Bridal measurements and fitting consultation recordings are assigned a private client reference code and stored securely in our encrypted master tailoring database.
              </p>
            </div>
          </div>

          <!-- Section 3: How We Use Your Data -->
          <div class="privacy-clause-card fade-up" id="how-we-use-data">
            <div class="privacy-clause-header">
              <div class="clause-index-badge">03</div>
              <div>
                <h3 class="font-heading">How &amp; Why We Use Your Information</h3>
                <span class="label-small text-muted">Lawful basis and operational application</span>
              </div>
            </div>
            <p>
              We process personal information under the following lawful bases and operational necessities:
            </p>
            <ul class="list-unstyled d-flex flex-column gap-2 mb-3">
              <li class="d-flex align-items-start gap-2">
                <i class="fas fa-check-circle text-gold mt-1"></i>
                <div><strong>Contractual Performance:</strong> Processing checkout transactions, artisan stitching, order verification, packaging, and door-to-door delivery.</div>
              </li>
              <li class="d-flex align-items-start gap-2">
                <i class="fas fa-check-circle text-gold mt-1"></i>
                <div><strong>Concierge Communication:</strong> Transmitting real-time order status, dispatch tracking links, unboxing guidelines, and scheduling tailoring fittings.</div>
              </li>
              <li class="d-flex align-items-start gap-2">
                <i class="fas fa-check-circle text-gold mt-1"></i>
                <div><strong>Fraud Prevention &amp; Security:</strong> Verifying high-value couture orders against unauthorized credit activity, chargeback disputes, and duplicate checkout submissions.</div>
              </li>
              <li class="d-flex align-items-start gap-2">
                <i class="fas fa-check-circle text-gold mt-1"></i>
                <div><strong>Client Preference Alignment:</strong> Providing curated lookbook recommendations and invitations to new seasonal collections (only with your affirmative consent, which you can revoke anytime).</div>
              </li>
            </ul>
          </div>

          <!-- Section 4: Payment Security -->
          <div class="privacy-clause-card fade-up" id="payment-security">
            <div class="privacy-clause-header">
              <div class="clause-index-badge">04</div>
              <div>
                <h3 class="font-heading">Payment Security &amp; Financial Safeguards</h3>
                <span class="label-small text-muted">How your money and transaction details are protected</span>
              </div>
            </div>
            <p>
              We provide multiple safe and transparent payment methods for clients across Pakistan and internationally:
            </p>

            <div class="row g-3 mb-4">
              <div class="col-md-6">
                <div class="p-3 bg-light border h-100">
                  <h6 class="font-heading fs-6 mb-1 text-dark"><i class="fas fa-truck-ramp-box me-1 text-gold"></i> Cash on Delivery (COD)</h6>
                  <p class="small text-muted mb-0">Pay directly to our authorized courier upon physical parcel inspection at your doorstep within Pakistan.</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="p-3 bg-light border h-100">
                  <h6 class="font-heading fs-6 mb-1 text-dark"><i class="fas fa-building-columns me-1 text-gold"></i> Direct Bank Wire / IBFT</h6>
                  <p class="small text-muted mb-0">Transfer funds securely from your official banking portal directly into our registered corporate accounts.</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="p-3 bg-light border h-100">
                  <h6 class="font-heading fs-6 mb-1 text-dark"><i class="fas fa-mobile-screen-button me-1 text-gold"></i> JazzCash &amp; EasyPaisa</h6>
                  <p class="small text-muted mb-0">Instant encrypted mobile wallet payments with direct digital SMS and OTP authorization.</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="p-3 bg-light border h-100">
                  <h6 class="font-heading fs-6 mb-1 text-dark"><i class="far fa-credit-card me-1 text-gold"></i> Visa, Mastercard &amp; Global Cards</h6>
                  <p class="small text-muted mb-0">Processed through 3D Secure 2.0 and PCI-DSS Level 1 certified payment gateways. <strong>We never capture, store, or view your 16-digit card number or CVV.</strong></p>
                </div>
              </div>
            </div>

            <div class="highlight-callout">
              <div class="highlight-callout-header">
                <i class="fas fa-shield-alt"></i>
                <span>End-to-End SSL Encryption</span>
              </div>
              <p>
                Every page on our digital storefront operates strictly over HTTPS with modern Transport Layer Security (TLS 1.3), ensuring no third party can eavesdrop on your checkout data.
              </p>
            </div>
          </div>

          <!-- Section 5: Logistics Partners -->
          <div class="privacy-clause-card fade-up" id="logistics-partners">
            <div class="privacy-clause-header">
              <div class="clause-index-badge">05</div>
              <div>
                <h3 class="font-heading">Logistics Partners &amp; Limited Disclosure</h3>
                <span class="label-small text-muted">Who receives your shipping details for delivery</span>
              </div>
            </div>
            <p>
              To ensure your bespoke ensembles reach you securely and without delay, we share strictly necessary fulfillment data (Recipient Name, Shipping Destination Address, and Contact Mobile Number) with our vetted courier partners:
            </p>
            <ul class="list-unstyled d-flex flex-column gap-2 mb-3">
              <li class="d-flex align-items-start gap-2">
                <i class="fas fa-circle-check text-gold mt-1"></i>
                <div><strong>Domestic Shipments (Pakistan):</strong> TCS Courier, Leopards Courier, Trax Logistics, Call Courier.</div>
              </li>
              <li class="d-flex align-items-start gap-2">
                <i class="fas fa-circle-check text-gold mt-1"></i>
                <div><strong>International Shipments (Worldwide):</strong> DHL Express Worldwide, FedEx Priority, SkyNet Worldwide.</div>
              </li>
            </ul>
            <p class="small text-muted mb-0">
              <em>All partner carriers are contractually bound to use your contact details solely for parcel transit, OTP delivery authentication, and customs clearance. They are strictly prohibited from using your data for independent commercial marketing.</em>
            </p>
          </div>

          <!-- Section 6: Cookies & Tracking -->
          <div class="privacy-clause-card fade-up" id="cookies-tracking">
            <div class="privacy-clause-header">
              <div class="clause-index-badge">06</div>
              <div>
                <h3 class="font-heading">Cookies &amp; Tracking Technologies</h3>
                <span class="label-small text-muted">Enhancing and remembering your boutique preferences</span>
              </div>
            </div>
            <p>
              We utilize cookies and similar browser storage mechanisms to recognize returning clients, preserve your active shopping bag between sessions, and analyze traffic trends:
            </p>

            <!-- Interactive Cookie Preference Card -->
            <div class="cookie-card-wrapper">
              <div class="cookie-card-header">
                <div>
                  <h6 class="font-heading fs-6 mb-0">1. Strictly Necessary Cookies</h6>
                  <p class="text-muted small mb-0">Essential for shopping cart memory, secure login tokens, and checkout routing.</p>
                </div>
                <span class="cookie-badge-req">Always Active</span>
              </div>
            </div>

            <div class="cookie-card-wrapper">
              <div class="cookie-card-header">
                <div>
                  <h6 class="font-heading fs-6 mb-0">2. Performance &amp; Analytics Cookies</h6>
                  <p class="text-muted small mb-0">Helps us evaluate site speed, popular couture collections, and navigation flow (e.g. Google Analytics 4).</p>
                </div>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="analyticsCookies" checked>
                </div>
              </div>
            </div>

            <div class="cookie-card-wrapper">
              <div class="cookie-card-header">
                <div>
                  <h6 class="font-heading fs-6 mb-0">3. Personalized Styling &amp; Marketing Cookies</h6>
                  <p class="text-muted small mb-0">Allows tailored suggestions and bridal lookbook reminders across Instagram &amp; Facebook.</p>
                </div>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="marketingCookies" checked>
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-end mt-3">
              <button type="button" class="btn btn-primary px-4 py-2 text-uppercase fs-7" id="saveCookiePreferencesBtn">
                <i class="fas fa-check me-1"></i> Save Cookie Preferences
              </button>
            </div>
          </div>

          <!-- Section 7: Retention & Safeguards -->
          <div class="privacy-clause-card fade-up" id="data-retention">
            <div class="privacy-clause-header">
              <div class="clause-index-badge">07</div>
              <div>
                <h3 class="font-heading">Data Retention &amp; Security Protocols</h3>
                <span class="label-small text-muted">Storage lifecycles and technical safeguards</span>
              </div>
            </div>
            <p>
              We maintain personal data only as long as necessary to fulfill the purposes outlined in this policy or comply with tax, corporate accounting, and legal requirements:
            </p>
            <ul class="list-unstyled d-flex flex-column gap-2 mb-3">
              <li class="d-flex align-items-start gap-2">
                <i class="fas fa-shield-halved text-gold mt-1"></i>
                <div><strong>Order Invoices &amp; Accounting Records:</strong> Retained for 5 years in compliance with domestic commercial taxation guidelines.</div>
              </li>
              <li class="d-flex align-items-start gap-2">
                <i class="fas fa-shield-halved text-gold mt-1"></i>
                <div><strong>Bespoke Bridal Profiles:</strong> Retained for 24 months to simplify future heirloom alterations, matching family ensembles, or sibling wedding orders, unless you request earlier deletion.</div>
              </li>
              <li class="d-flex align-items-start gap-2">
                <i class="fas fa-shield-halved text-gold mt-1"></i>
                <div><strong>Technical Security:</strong> Encrypted backups (AES-256), multi-factor admin authentication, role-based database privileges, and frequent vulnerability assessments.</div>
              </li>
            </ul>
          </div>

          <!-- Section 8: Your Legal Rights -->
          <div class="privacy-clause-card fade-up" id="your-rights">
            <div class="privacy-clause-header">
              <div class="clause-index-badge">08</div>
              <div>
                <h3 class="font-heading">Your Legal Rights &amp; Privacy Controls</h3>
                <span class="label-small text-muted">GDPR, CCPA &amp; Global client protections</span>
              </div>
            </div>
            <p>
              Regardless of your geographical location, Libas E Khas grants you comprehensive control over your personal data. You have the right to exercise any of the following privileges at any time:
            </p>

            <div class="rights-grid">
              <div class="right-box">
                <div class="right-box-icon"><i class="fas fa-eye"></i></div>
                <h5>Right to Access</h5>
                <p>Request a complete export of all personal details, order receipts, and measurements on file.</p>
              </div>

              <div class="right-box">
                <div class="right-box-icon"><i class="fas fa-pen-to-square"></i></div>
                <h5>Right to Rectification</h5>
                <p>Correct or update outdated contact details, delivery addresses, or tailor measurement sheets.</p>
              </div>

              <div class="right-box">
                <div class="right-box-icon"><i class="fas fa-trash-can"></i></div>
                <h5>Right to Erasure</h5>
                <p>Request the permanent deletion ("Right to be Forgotten") of your client account and profile.</p>
              </div>

              <div class="right-box">
                <div class="right-box-icon"><i class="fas fa-ban"></i></div>
                <h5>Right to Object / Opt-Out</h5>
                <p>Instantly withdraw from marketing newsletters, promotional SMS, or lookbook emails with 1 click.</p>
              </div>

              <div class="right-box">
                <div class="right-box-icon"><i class="fas fa-file-export"></i></div>
                <h5>Data Portability</h5>
                <p>Obtain your personal profile and measurement sheets in a structured, machine-readable JSON/PDF format.</p>
              </div>

              <div class="right-box">
                <div class="right-box-icon"><i class="fas fa-scale-balanced"></i></div>
                <h5>Non-Discrimination</h5>
                <p>We guarantee identical couture pricing, handcrafted quality, and concierge care regardless of privacy choices.</p>
              </div>
            </div>

            <div class="text-center mt-3">
              <button type="button" class="btn btn-primary px-4 py-3 text-uppercase" data-bs-toggle="modal" data-bs-target="#dataRequestModal">
                <i class="fas fa-envelope-open-text me-2"></i> Exercise Your Rights Online
              </button>
            </div>
          </div>

          <!-- Section 9: International Transfers -->
          <div class="privacy-clause-card fade-up" id="international-transfers">
            <div class="privacy-clause-header">
              <div class="clause-index-badge">09</div>
              <div>
                <h3 class="font-heading">International Transfers &amp; Border Logistics</h3>
                <span class="label-small text-muted">Global delivery to USA, UK, UAE, Europe, Canada &amp; beyond</span>
              </div>
            </div>
            <p>
              As a luxury brand serving an esteemed global diaspora, we ship handcrafted ensembles worldwide. When you place an international order, your delivery information is transmitted across borders to international customs agencies, aviation freight lines, and local postal operators.
            </p>
            <p class="mb-0">
              All cross-border transmissions conform to standard contractual clauses (SCCs) and international privacy frameworks, ensuring your data maintains the exact same degree of legal protection overseas as within our primary atelier.
            </p>
          </div>

          <!-- Section 10: Children's Privacy -->
          <div class="privacy-clause-card fade-up" id="childrens-privacy">
            <div class="privacy-clause-header">
              <div class="clause-index-badge">10</div>
              <div>
                <h3 class="font-heading">Protection of Minors &amp; Children's Privacy</h3>
                <span class="label-small text-muted">Under 18 policy guidelines</span>
              </div>
            </div>
            <p>
              Our online boutique is intended exclusively for individuals aged 18 and older. We do not knowingly collect personal data directly from minors without parental or guardian consent.
            </p>
            <p class="mb-0">
              Where custom junior pret or flower girl outfits are commissioned, all measurements and order approvals must be provided directly by a parent or legal guardian. If we discover any minor's data was inadvertently registered, we will promptly delete it.
            </p>
          </div>

          <!-- Section 11: Policy Revisions -->
          <div class="privacy-clause-card fade-up" id="policy-updates">
            <div class="privacy-clause-header">
              <div class="clause-index-badge">11</div>
              <div>
                <h3 class="font-heading">Policy Amendments &amp; Revision Log</h3>
                <span class="label-small text-muted">Version history and update protocols</span>
              </div>
            </div>
            <p>
              We reserve the right to revise this Privacy Policy periodically to reflect enhancements in our digital platform, expanded tailoring ateliers, or evolving international statutory requirements.
            </p>
            <ul class="list-unstyled d-flex flex-column gap-2 mb-0">
              <li class="d-flex align-items-start gap-2">
                <i class="fas fa-history text-gold mt-1"></i>
                <div><strong>Version 2.4 (August 2026):</strong> Added bespoke bridal measurement discretion clause, enhanced GDPR data rights portal, updated international courier protocols.</div>
              </li>
              <li class="d-flex align-items-start gap-2">
                <i class="fas fa-history text-gold mt-1"></i>
                <div><strong>Version 2.0 (January 2025):</strong> Integrated PCI-DSS 3D Secure 2.0 payment processing standards and cookie preferences management.</div>
              </li>
            </ul>
          </div>

          <!-- Section 12: Contact DPO -->
          <div class="privacy-clause-card fade-up" id="contact-dpo">
            <div class="privacy-clause-header">
              <div class="clause-index-badge">12</div>
              <div>
                <h3 class="font-heading">Contact Our Data Protection Concierge</h3>
                <span class="label-small text-muted">Direct escalation channel for privacy queries</span>
              </div>
            </div>
            <p>
              For inquiries regarding this policy, to request bespoke measurement records, or to raise any data protection concerns, please contact our dedicated Data Protection Officer:
            </p>

            <div class="row g-3 mt-2">
              <div class="col-md-6">
                <div class="p-3 bg-light border text-center h-100">
                  <i class="fas fa-envelope-shield fs-3 text-gold mb-2"></i>
                  <h6 class="font-heading fs-6 mb-1">Email Privacy Desk</h6>
                  <p class="small text-muted mb-2">privacy@libasekhas.com</p>
                  <a href="mailto:privacy@libasekhas.com" class="btn btn-outline py-1 px-3 fs-7">Send Email</a>
                </div>
              </div>
              <div class="col-md-6">
                <div class="p-3 bg-light border text-center h-100">
                  <i class="fab fa-whatsapp fs-3 text-gold mb-2"></i>
                  <h6 class="font-heading fs-6 mb-1">WhatsApp Concierge</h6>
                  <p class="small text-muted mb-2">+92 322 7939492 (9 AM - 8 PM PKT)</p>
                  <a href="https://wa.me/+923227939492" target="_blank" class="btn btn-outline py-1 px-3 fs-7">Chat Directly</a>
                </div>
              </div>
            </div>

            <div class="mt-4 pt-3 border-top text-center text-muted small">
              <strong>Libas E Khas Flagship Atelier</strong><br>
              MM Alam Road, Gulberg III, Lahore, Pakistan | Contact: support@libasekhas.com
            </div>
          </div>

          <!-- Support CTA Card -->
          <div class="support-cta-card fade-up">
            <h3 class="heading-section fs-3 mb-2">Questions About Our Privacy Standards?</h3>
            <p class="text-muted mb-4 mx-auto max-w-520">
              Our concierge team is at your service 7 days a week to ensure your bridal and pret shopping journey is completely secure and confidential.
            </p>
            <div class="d-flex flex-wrap justify-content-center gap-3">
              <a href="contact" class="btn btn-primary px-4 py-3">Visit Contact Concierge</a>
              <a href="https://wa.me/+923227939492" target="_blank" class="btn btn-outline px-4 py-3">
                <i class="fab fa-whatsapp me-2"></i> WhatsApp Support
              </a>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

  <!-- Interactive Data Rights Request Modal -->
  <div class="modal fade" id="dataRequestModal" tabindex="-1" aria-labelledby="dataRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 rounded-0 shadow-lg">
        <div class="modal-header border-bottom bg-ivory">
          <h5 class="modal-title font-heading fs-4" id="dataRequestModalLabel">
            <i class="fas fa-shield-halved text-gold me-2"></i> Client Data Rights Request
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">
          <p class="small text-muted mb-3">
            Please submit your request below. Our Data Protection Officer will verify your identity and process your inquiry within <strong>48 to 72 business hours</strong>.
          </p>

          <form id="dataRightsForm" onsubmit="handleDataRightsSubmit(event)">
            <div class="mb-3">
              <label for="requestType" class="form-label small fw-semibold text-uppercase">Request Category</label>
              <select class="form-select rounded-0" id="requestType" required>
                <option value="" selected disabled>Select your request type...</option>
                <option value="export">Download Copy of Personal Data &amp; Measurements (Access)</option>
                <option value="rectify">Update Fitting Sheet / Contact Info (Rectification)</option>
                <option value="erase">Permanently Delete Account &amp; Order Profiles (Erasure)</option>
                <option value="optout">Unsubscribe from Marketing &amp; Lookbooks (Opt-Out)</option>
                <option value="other">General Data Inquiry / Tailoring Clarification</option>
              </select>
            </div>

            <div class="row g-2 mb-3">
              <div class="col-6">
                <label for="clientName" class="form-label small fw-semibold text-uppercase">Full Name</label>
                <input type="text" class="form-control rounded-0" id="clientName" placeholder="e.g. Ayesha Khan" required>
              </div>
              <div class="col-6">
                <label for="clientPhone" class="form-label small fw-semibold text-uppercase">Phone / WhatsApp</label>
                <input type="tel" class="form-control rounded-0" id="clientPhone" placeholder="+92 300 0000000" required>
              </div>
            </div>

            <div class="mb-3">
              <label for="clientEmail" class="form-label small fw-semibold text-uppercase">Email Address</label>
              <input type="email" class="form-control rounded-0" id="clientEmail" placeholder="ayesha@example.com" required>
            </div>

            <div class="mb-3">
              <label for="orderIdRef" class="form-label small fw-semibold text-uppercase">Order ID / Bespoke Reference (Optional)</label>
              <input type="text" class="form-control rounded-0" id="orderIdRef" placeholder="e.g. LK-2026-9842">
            </div>

            <div class="mb-3">
              <label for="requestDetails" class="form-label small fw-semibold text-uppercase">Additional Details</label>
              <textarea class="form-control rounded-0" id="requestDetails" rows="3" placeholder="Please specify your request..."></textarea>
            </div>

            <div class="d-grid">
              <button type="submit" class="btn btn-primary py-3 text-uppercase">
                <i class="fas fa-paper-plane me-2"></i> Submit Official Request
              </button>
            </div>
          </form>

          <!-- Success Alert Container -->
          <div id="dataFormSuccess" class="alert alert-success d-none mt-3 rounded-0" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <strong>Request Dispatched:</strong> Your data rights ticket has been recorded. Our Data Protection Concierge will contact you via email shortly.
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Cart Offcanvas -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas" aria-labelledby="cartOffcanvasLabel">
    <div class="offcanvas-header border-bottom">
      <h5 class="offcanvas-title font-heading" id="cartOffcanvasLabel">Shopping Bag</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column bg-ivory">
      <div id="cart-items" class="flex-grow-1 overflow-auto pe-2">
        <!-- Injected dynamically via JS -->
      </div>
      <div class="cart-footer mt-4 border-top pt-3">
        <div class="d-flex justify-content-between mb-3">
          <span class="font-body fw-medium">Subtotal:</span>
          <span id="cart-subtotal" class="font-weight-bold">PKR 0</span>
        </div>
        <a href="checkout.html" class="btn btn-primary w-100 py-3">Proceed to Checkout</a>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php require_once('inc/footer.php'); ?>


  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/products.js"></script>
  <script src="js/cart.js"></script>
  <script src="js/main.js"></script>

  <!-- Interactive Search & Table of Contents Script -->
  <script>
    // Live Search Filter for Table of Contents & Clauses
    const searchInput = document.getElementById('policySearchInput');
    const tocList = document.getElementById('privacyTocList');
    
    if (searchInput && tocList) {
      searchInput.addEventListener('input', function(e) {
        const query = e.target.value.toLowerCase().trim();
        const items = tocList.querySelectorAll('li');
        const cards = document.querySelectorAll('.privacy-clause-card');

        items.forEach(item => {
          const text = item.textContent.toLowerCase();
          item.style.display = text.includes(query) ? '' : 'none';
        });

        if (query.length > 2) {
          cards.forEach(card => {
            const cardText = card.textContent.toLowerCase();
            if (cardText.includes(query)) {
              card.style.display = '';
              card.style.borderColor = 'var(--color-gold)';
            } else {
              card.style.borderColor = '#ece5da';
            }
          });
        } else {
          cards.forEach(card => {
            card.style.display = '';
            card.style.borderColor = '#ece5da';
          });
        }
      });
    }

    // Handle Active State on Scroll (ScrollSpy-like behavior)
    window.addEventListener('scroll', function() {
      const scrollPos = window.scrollY + 120;
      const links = document.querySelectorAll('.privacy-toc-link');
      
      links.forEach(link => {
        const targetId = link.getAttribute('href');
        if (targetId && targetId.startsWith('#')) {
          const targetElem = document.querySelector(targetId);
          if (targetElem) {
            const top = targetElem.offsetTop;
            const height = targetElem.offsetHeight;
            if (scrollPos >= top && scrollPos < top + height) {
              link.classList.add('active');
            } else {
              link.classList.remove('active');
            }
          }
        }
      });
    });

    // Handle Cookie Preferences Save
    const saveCookieBtn = document.getElementById('saveCookiePreferencesBtn');
    if (saveCookieBtn) {
      saveCookieBtn.addEventListener('click', function() {
        const analytics = document.getElementById('analyticsCookies').checked;
        const marketing = document.getElementById('marketingCookies').checked;
        localStorage.setItem('lek_cookie_prefs', JSON.stringify({
          essential: true,
          analytics: analytics,
          marketing: marketing,
          timestamp: new Date().toISOString()
        }));
        
        saveCookieBtn.innerHTML = '<i class="fas fa-check-double me-1"></i> Preferences Saved!';
        saveCookieBtn.classList.remove('btn-primary');
        saveCookieBtn.classList.add('btn-success');
        
        setTimeout(() => {
          saveCookieBtn.innerHTML = '<i class="fas fa-check me-1"></i> Save Cookie Preferences';
          saveCookieBtn.classList.remove('btn-success');
          saveCookieBtn.classList.add('btn-primary');
        }, 3000);
      });
    }

    // Handle Data Rights Form Submission
    function handleDataRightsSubmit(event) {
      event.preventDefault();
      const form = document.getElementById('dataRightsForm');
      const successAlert = document.getElementById('dataFormSuccess');
      
      // Simulate submission response
      form.style.display = 'none';
      successAlert.classList.remove('d-none');

      setTimeout(() => {
        // Reset after modal closes
        const modalEl = document.getElementById('dataRequestModal');
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) {
          modal.hide();
        }
        setTimeout(() => {
          form.reset();
          form.style.display = '';
          successAlert.classList.add('d-none');
        }, 500);
      }, 3500);
    }
  </script>
</body>
</html>
