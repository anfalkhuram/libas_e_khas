<?php
require_once('../inc/db.php');

header('Content-Type: application/json');

$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id <= 0) {
    echo json_encode(['success' => false, 'error' => 'Invalid product ID']);
    exit;
}

// Fetch colors
$colors = [];
$res = $conn->query("SELECT * FROM product_colors WHERE product_id = $product_id AND status = 1 ORDER BY sort_order ASC");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $colors[] = $row;
    }
}

// Fetch options
$options = [];
$res = $conn->query("SELECT * FROM product_options WHERE product_id = $product_id AND status = 1 ORDER BY sort_order ASC");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $options[] = $row;
    }
}

// Fetch sizes
$sizes = [];
$res = $conn->query("SELECT * FROM sizes WHERE status = 1 ORDER BY sort_order ASC");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $sizes[] = $row;
    }
}

// Fetch variations
$variations = [];
$res = $conn->query("SELECT pv.*, s.name as size_name 
                    FROM product_variations pv 
                    LEFT JOIN sizes s ON pv.size_id = s.id 
                    WHERE pv.product_id = $product_id AND pv.status = 1");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $variations[] = $row;
    }
}

echo json_encode([
    'success' => true,
    'colors' => $colors,
    'options' => $options,
    'sizes' => $sizes,
    'variations' => $variations
]);
?>
