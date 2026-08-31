<?php
require_once('../../inc/db.php');
require_once('../../inc/image_helper.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
    exit;
}

// Basic form data
$name = $conn->real_escape_string($_POST['name'] ?? '');
$category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : NULL;
$price = floatval($_POST['price'] ?? 0);
$sale = isset($_POST['sale']) ? 1 : 0;
$salePrice = $sale ? floatval($_POST['salePrice'] ?? 0) : NULL;
$shortDesc = $conn->real_escape_string($_POST['shortDescription'] ?? '');
$desc = $conn->real_escape_string($_POST['description'] ?? '');
$fabric = $conn->real_escape_string($_POST['fabric'] ?? '');
$collection = $conn->real_escape_string($_POST['collection'] ?? '');
$sub_category_id = isset($_POST['sub_category_id']) ? intval($_POST['sub_category_id']) : NULL;
$stock = intval($_POST['stock'] ?? 0);
$availability = $conn->real_escape_string($_POST['availability'] ?? 'In Stock');
$tags = $conn->real_escape_string($_POST['tags'] ?? '');
$sizes = $conn->real_escape_string($_POST['sizes'] ?? '');
$colors = $conn->real_escape_string($_POST['colors'] ?? '');
$pieces = $conn->real_escape_string($_POST['pieces'] ?? '1 Piece');

// Validation
if (empty($name) || empty($price)) {
    echo json_encode(['success' => false, 'error' => 'Product Name and Regular Price are required.']);
    exit;
}

// Directory for uploads
$uploadDir = '../../assets/images/products/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Helper to handle single upload
function handleUpload($fileObj, $dir) {
    if (isset($fileObj) && $fileObj['error'] === UPLOAD_ERR_OK) {
        $originalName = pathinfo($fileObj['name'], PATHINFO_FILENAME);
        $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $originalName);
        $filename = time() . '_' . $safeName . '.webp';
        $target = $dir . $filename;
        if (processAndSaveWebP($fileObj['tmp_name'], $target)) {
            return 'assets/images/products/' . $filename;
        }
    }
    return '';
}

// Handle main and hover image
$mainImage = handleUpload($_FILES['main_image'] ?? null, $uploadDir);
$hoverImage = handleUpload($_FILES['hover_image'] ?? null, $uploadDir);

if (empty($mainImage)) {
    echo json_encode(['success' => false, 'error' => 'Main Image is required.']);
    exit;
}

// Insert product
$salePriceVal = $salePrice === NULL ? "NULL" : $salePrice;
$catIdVal = $category_id === NULL ? "NULL" : $category_id;
$subCatIdVal = $sub_category_id === NULL ? "NULL" : $sub_category_id;

$sql = "INSERT INTO products (name, category_id, price, sale, salePrice, shortDescription, description, fabric, collection, sub_category_id, stock, availability, tags, sizes, colors, pieces, main_image, hover_image) 
        VALUES ('$name', $catIdVal, $price, $sale, $salePriceVal, '$shortDesc', '$desc', '$fabric', '$collection', $subCatIdVal, $stock, '$availability', '$tags', '$sizes', '$colors', '$pieces', '$mainImage', '$hoverImage')";

if ($conn->query($sql)) {
    $product_id = $conn->insert_id;
    
    // Handle gallery images
    if (!empty($_FILES['gallery_images']['name'][0])) {
        // Enforce maximum 5 images on server-side
        $numFiles = count($_FILES['gallery_images']['name']);
        if ($numFiles > 5) {
            echo json_encode(['success' => false, 'error' => 'You can only upload a maximum of 5 gallery images.']);
            exit;
        }

        foreach ($_FILES['gallery_images']['name'] as $key => $val) {
            if ($_FILES['gallery_images']['error'][$key] === UPLOAD_ERR_OK) {
                $originalName = pathinfo($_FILES['gallery_images']['name'][$key], PATHINFO_FILENAME);
                $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $originalName);
                $filename = time() . '_' . $safeName . '_' . $key . '.webp';
                $target = $uploadDir . $filename;
                
                if (processAndSaveWebP($_FILES['gallery_images']['tmp_name'][$key], $target)) {
                    $dbPath = 'assets/images/products/' . $filename;
                    $conn->query("INSERT INTO product_images (product_id, image_path) VALUES ($product_id, '$dbPath')");
                }
            }
        }
    }
    
    // Handle Variations
    $colorsJson = $_POST['variations_colors'] ?? '[]';
    $optionsJson = $_POST['variations_options'] ?? '[]';
    $varsJson = $_POST['variations_data'] ?? '[]';

    $colorsData = json_decode($colorsJson, true) ?? [];
    $optionsData = json_decode($optionsJson, true) ?? [];
    $varsData = json_decode($varsJson, true) ?? [];

    if (!empty($varsData)) {
        $colorIdMap = [];
        $optionIdMap = [];
        
        // Insert colors
        $colorSort = 1;
        foreach ($colorsData as $c) {
            $cName = $conn->real_escape_string($c['name']);
            $cImage = '';
            $fileKey = 'color_img_' . $c['id'];
            if (isset($_FILES[$fileKey])) {
                $cImage = handleUpload($_FILES[$fileKey], $uploadDir);
            }
            $conn->query("INSERT INTO product_colors (product_id, color_name, image, sort_order) VALUES ($product_id, '$cName', '$cImage', $colorSort)");
            $colorIdMap[$c['name']] = $conn->insert_id;
            $colorSort++;
        }
        
        // Insert options
        $optionSort = 1;
        foreach ($optionsData as $o) {
            $oName = $conn->real_escape_string($o['name']);
            $conn->query("INSERT INTO product_options (product_id, option_name, sort_order) VALUES ($product_id, '$oName', $optionSort)");
            $optionIdMap[$o['name']] = $conn->insert_id;
            $optionSort++;
        }
        
        // Insert variations
        foreach ($varsData as $v) {
            $vColorId = isset($colorIdMap[$v['color']]) ? $colorIdMap[$v['color']] : "NULL";
            $vOptionId = isset($optionIdMap[$v['option']]) ? $optionIdMap[$v['option']] : "NULL";
            $vSizeId = !empty($v['size_id']) ? intval($v['size_id']) : "NULL";
            
            $vSku = $conn->real_escape_string($v['sku']);
            
            $vRegularPrice = $v['price'] !== '' ? floatval($v['price']) : $price;
            $vSalePrice = $v['sale_price'] !== '' ? floatval($v['sale_price']) : NULL;
            
            if ($vSalePrice !== NULL && $vSalePrice < $vRegularPrice) {
                $dbPrice = $vSalePrice;
                $dbOriginalPrice = $vRegularPrice;
            } else {
                $dbPrice = $vRegularPrice;
                $dbOriginalPrice = "NULL";
            }

            $vStock = intval($v['stock']);
            $vStatus = intval($v['status']);
            
            $conn->query("INSERT INTO product_variations (product_id, color_id, option_id, size_id, sku, price, original_price, stock_quantity, status) VALUES ($product_id, $vColorId, $vOptionId, $vSizeId, '$vSku', $dbPrice, $dbOriginalPrice, $vStock, $vStatus)");
        }
    }
    
    echo json_encode(['success' => true, 'product_id' => $product_id]);
} else {
    echo json_encode(['success' => false, 'error' => 'Database Error: ' . $conn->error]);
}

$conn->close();
?>
