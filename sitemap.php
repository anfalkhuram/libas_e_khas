<?php
require_once('inc/db.php');

header("Content-Type: application/xml; charset=utf-8");

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$domain = $protocol . "://" . $_SERVER['HTTP_HOST'];

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

// Function to print a URL node
function printUrlNode($loc, $lastmod = '', $changefreq = 'weekly', $priority = '0.8') {
    echo "  <url>\n";
    echo "    <loc>" . htmlspecialchars($loc) . "</loc>\n";
    if (!empty($lastmod)) {
        echo "    <lastmod>" . htmlspecialchars($lastmod) . "</lastmod>\n";
    }
    echo "  </url>\n";
}

// 1. Static Pages
$staticPages = [
    '/' => date('c'), // Home
    '/shop.php' => date('c'),
    '/about.php' => date('c'),
    '/contact.php' => date('c'),
    '/faqs.php' => date('c'),
    '/return-exchange.php' => date('c')
];

foreach ($staticPages as $url => $lastmod) {
    printUrlNode($domain . $url, $lastmod);
}

// 2. Categories
$catRes = $conn->query("SELECT name FROM categories WHERE status = 1");
if ($catRes && $catRes->num_rows > 0) {
    while ($row = $catRes->fetch_assoc()) {
        $catUrl = $domain . "/shop.php?cat=" . urlencode($row['name']);
        printUrlNode($catUrl, date('c'));
    }
}

// 3. Subcategories
$subcatRes = $conn->query("SELECT name FROM sub_categories WHERE status = 1");
if ($subcatRes && $subcatRes->num_rows > 0) {
    while ($row = $subcatRes->fetch_assoc()) {
        $subcatUrl = $domain . "/shop.php?subcat=" . urlencode($row['name']);
        printUrlNode($subcatUrl, date('c'));
    }
}

// 4. Products



$prodRes = $conn->query("SELECT id, created_at FROM products");
if ($prodRes && $prodRes->num_rows > 0) {
    while ($row = $prodRes->fetch_assoc()) {
        $prodUrl = $domain . "/product-details.php?id=" . $row['id'];
        $lastmod = isset($row['created_at']) && !empty($row['created_at']) ? date('c', strtotime($row['created_at'])) : date('c');
        printUrlNode($prodUrl, $lastmod);
    }
}

echo '</urlset>';
?>
