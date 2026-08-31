 <footer class="footer">
    <div class="container">
      <div class="row g-4">
        <div class="col-lg-3 col-md-6 mb-4 mb-lg-0 pe-lg-5 text-center text-md-start">
          <img src="assets/images/logo.webp" alt="Libas E Khas" class="mb-3 footer-logo-img w-50" >
          <p class="">Luxury Pakistani fashion, crafted with heritage and presented with modern elegance.</p>
        </div>
        <div class="col-lg-2 col-md-6 mb-4 mb-lg-0 text-center text-md-start">
          <h5>Shop</h5>
          <ul>
            <?php
            require_once('inc/db.php');
            $footer_cat_sql = "SELECT id, name FROM categories WHERE status = 1";
            $footer_cat_res = $conn->query($footer_cat_sql);
            if ($footer_cat_res && $footer_cat_res->num_rows > 0) {
                while($cat_row = $footer_cat_res->fetch_assoc()) {
                    echo '<li><a href="shop?cat=' . urlencode($cat_row['name']) . '">' . htmlspecialchars($cat_row['name']) . '</a></li>';
                }
            }
            ?>
          </ul>
        </div>
        <div class="col-lg-3 col-md-6 mb-4 mb-lg-0 text-center text-md-start">
          <h5>Customer Care</h5>
          <ul>
            <li><a href="contact">Contact Us</a></li>
            <li><a href="return-exchange">Returns & Exchange</a></li>
            <li><a href="faqs">FAQs</a></li>
          </ul>
        </div>
        <div class="col-lg-4 col-md-6 text-center text-md-start">
          <h5>Social Media</h5>
          <p>Follow us on our social channels for latest arrivals, styling inspirations, and exclusive updates.</p>
          <div class="mt-3 d-flex justify-content-center justify-content-md-start gap-4">
            <a href="https://www.instagram.com/libasekhas_sargodha/" target="_blank" class="text-white social-icon" title="Instagram"><i class="fab fa-instagram fs-4"></i></a>
            <a href="https://www.facebook.com/libasekhassargodha" target="_blank" class="text-white social-icon" title="Facebook"><i class="fab fa-facebook fs-4"></i></a>
            <a href="https://wa.me/+923227939492" target="_blank" class="text-white social-icon" title="WhatsApp"><i class="fab fa-whatsapp fs-4"></i></a>
            <a href="https://www.tiktok.com/@libasekhassargodha" target="_blank" class="text-white social-icon" title="TikTok"><i class="fa-brands fa-tiktok fs-4"></i></a>
          </div>
        </div>
      </div>
      <div class="footer-bottom d-flex flex-column flex-md-row justify-content-between align-items-center">
        <div class="mb-2 mb-md-0">
          &copy; <?php echo date("Y"); ?> Libas E Khas. All Rights Reserved.
          <a href="privacy-policy" class="text-gold text-decoration-none ms-2">Privacy &amp; Policy</a>
        </div>
        <div>
          Developed by : <a href="https://anfalkhuram.com" target="_blank" class="text-gold text-decoration-none">Anfal Khuram</a>
        </div>
      </div>
    </div>
  </footer>