 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <?php
 require_once(__DIR__ . '/db.php');
 $productsData = [];
 
 // Fetch all active products
 $prod_sql = "SELECT p.*, c.name as category_name, sc.name as sub_category_name 
              FROM products p 
              LEFT JOIN categories c ON p.category_id = c.id 
              LEFT JOIN sub_categories sc ON p.sub_category_id = sc.id 
              WHERE p.status = 1 AND (c.status = 1 OR c.status IS NULL) AND (sc.status = 1 OR sc.status IS NULL)
              ORDER BY p.id DESC";
 $prod_res = $conn->query($prod_sql);
 
 if ($prod_res && $prod_res->num_rows > 0) {
     while ($row = $prod_res->fetch_assoc()) {
         $pid = intval($row['id']);
         
         // Fetch gallery images
         $gallery = [];
         $gal_sql = "SELECT image_path FROM product_images WHERE product_id = $pid";
         $gal_res = $conn->query($gal_sql);
         if ($gal_res && $gal_res->num_rows > 0) {
             while ($gRow = $gal_res->fetch_assoc()) {
                 $gallery[] = $gRow['image_path'];
             }
         }
         // If no gallery images, use main image
         if (empty($gallery)) {
             $gallery[] = $row['main_image'];
         }
         
         // Fetch sizes correctly
         $sizesStr = htmlspecialchars_decode($row['sizes']);
         $sizesArr = !empty(trim($sizesStr)) ? array_map('trim', explode(',', $sizesStr)) : [];
         
         // Fetch colors correctly
         $colorsStr = htmlspecialchars_decode($row['colors'] ?? '');
         $colorsArr = !empty(trim($colorsStr)) ? array_map('trim', explode(',', $colorsStr)) : [];
         
         // Fetch reviews
         $reviews = [];
         $rev_sql = "SELECT name, rating, review_text as text, created_at FROM reviews WHERE product_id = $pid AND status = 1 ORDER BY created_at DESC";
         $rev_res = $conn->query($rev_sql);
         if ($rev_res && $rev_res->num_rows > 0) {
             while ($rRow = $rev_res->fetch_assoc()) {
                 $reviews[] = [
                     'name' => htmlspecialchars_decode($rRow['name']),
                     'rating' => intval($rRow['rating']),
                     'text' => htmlspecialchars_decode($rRow['text']),
                     'date' => date('M d, Y', strtotime($rRow['created_at']))
                 ];
             }
         }
         
         $productsData[] = [
             'id' => $pid,
             'name' => htmlspecialchars_decode($row['name']),
             'category' => htmlspecialchars_decode($row['category_name']),
             'sub_category' => htmlspecialchars_decode($row['sub_category_name'] ?? ''),
             'price' => floatval($row['price']),
             'image' => $row['main_image'],
             'hoverImage' => $row['hover_image'],
             'images' => $gallery,
             'sale' => boolval($row['sale']),
             'salePrice' => floatval($row['salePrice']),
             'description' => htmlspecialchars_decode($row['description']),
             'shortDescription' => htmlspecialchars_decode($row['shortDescription']),
             'fabric' => htmlspecialchars_decode($row['fabric']),
             'collection' => htmlspecialchars_decode($row['collection']),
             'sizes' => $sizesArr,
             'colors' => $colorsArr,
             'sku' => 'LK-' . str_pad($pid, 3, '0', STR_PAD_LEFT),
             'availability' => $row['availability'],
             'reviews' => $reviews,
         ];
     }
 }
 ?>
 <script>
    const products = <?= json_encode($productsData) ?>;
    
    function formatPrice(price) {
        return "PKR " + parseFloat(price).toLocaleString('en-US');
    }
 </script>
  <script src="js/cart.js"></script>
  <script src="js/main.js"></script>
 