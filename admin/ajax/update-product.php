<?php
require_once('../../inc/db.php');
require_once('../../inc/image_helper.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
    exit;
}

$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
if ($product_id === 0) {
    echo json_encode(['success' => false, 'error' => 'Invalid Product ID.']);
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

$mainImage = handleUpload($_FILES['main_image'] ?? null, $uploadDir);
$hoverImage = handleUpload($_FILES['hover_image'] ?? null, $uploadDir);

$salePriceVal = $salePrice === NULL ? "NULL" : $salePrice;
$catIdVal = $category_id === NULL ? "NULL" : $category_id;
$subCatIdVal = $sub_category_id === NULL ? "NULL" : $sub_category_id;

$updateSql = "UPDATE products SET 
    name = '$name',
    category_id = $catIdVal,
    price = $price,
    sale = $sale,
    salePrice = $salePriceVal,
    shortDescription = '$shortDesc',
    description = '$desc',
    fabric = '$fabric',
    collection = '$collection',
    sub_category_id = $subCatIdVal,
    stock = $stock,
    availability = '$availability',
    tags = '$tags',
    sizes = '$sizes',
    colors = '$colors',
    pieces = '$pieces'";

if (!empty($mainImage)) {
    $updateSql .= ", main_image = '$mainImage'";
}
if (!empty($hoverImage)) {
    $updateSql .= ", hover_image = '$hoverImage'";
}

$updateSql .= " WHERE id = $product_id";

if ($conn->query($updateSql)) {
    
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

    $colorIdMap = [];
    $optionIdMap = [];
    $keepColorIds = [];
    $keepOptionIds = [];
    $keepVarIds = [];

    // Sync colors
    $colorSort = 1;
    foreach ($colorsData as $c) {
        $cName = $conn->real_escape_string($c['name']);
        $cImage = '';
        $fileKey = 'color_img_' . $c['id'];
        
        $updateImgSql = "";
        if (isset($_FILES[$fileKey])) {
            $uploaded = handleUpload($_FILES[$fileKey], $uploadDir);
            if($uploaded) {
                $cImage = $uploaded;
                $updateImgSql = ", image = '$cImage'";
            }
        }
        
        if (strpos($c['id'], 'new_') === 0) {
            $conn->query("INSERT INTO product_colors (product_id, color_name, image, sort_order) VALUES ($product_id, '$cName', '$cImage', $colorSort)");
            $colorIdMap[$c['name']] = $conn->insert_id;
            $keepColorIds[] = $conn->insert_id;
        } else {
            $cid = intval($c['id']);
            $conn->query("UPDATE product_colors SET color_name = '$cName', sort_order = $colorSort $updateImgSql WHERE id = $cid AND product_id = $product_id");
            $colorIdMap[$c['name']] = $cid;
            $keepColorIds[] = $cid;
        }
        $colorSort++;
    }

    // Delete removed colors
    $keepColorIdsStr = implode(',', $keepColorIds);
    if (!empty($keepColorIdsStr)) {
        $conn->query("DELETE FROM product_colors WHERE product_id = $product_id AND id NOT IN ($keepColorIdsStr)");
    } else {
        $conn->query("DELETE FROM product_colors WHERE product_id = $product_id");
    }

    // Sync options
    $optionSort = 1;
    foreach ($optionsData as $o) {
        $oName = $conn->real_escape_string($o['name']);
        if (strpos($o['id'], 'new_') === 0) {
            $conn->query("INSERT INTO product_options (product_id, option_name, sort_order) VALUES ($product_id, '$oName', $optionSort)");
            $optionIdMap[$o['name']] = $conn->insert_id;
            $keepOptionIds[] = $conn->insert_id;
        } else {
            $oid = intval($o['id']);
            $conn->query("UPDATE product_options SET option_name = '$oName', sort_order = $optionSort WHERE id = $oid AND product_id = $product_id");
            $optionIdMap[$o['name']] = $oid;
            $keepOptionIds[] = $oid;
        }
        $optionSort++;
    }

    // Delete removed options
    $keepOptionIdsStr = implode(',', $keepOptionIds);
    if (!empty($keepOptionIdsStr)) {
        $conn->query("DELETE FROM product_options WHERE product_id = $product_id AND id NOT IN ($keepOptionIdsStr)");
    } else {
        $conn->query("DELETE FROM product_options WHERE product_id = $product_id");
    }

    // Sync variations
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
        
        if ($v['id'] === 'new' || empty($v['id'])) {
            $conn->query("INSERT INTO product_variations (product_id, color_id, option_id, size_id, sku, price, original_price, stock_quantity, status) VALUES ($product_id, $vColorId, $vOptionId, $vSizeId, '$vSku', $dbPrice, $dbOriginalPrice, $vStock, $vStatus)");
            $keepVarIds[] = $conn->insert_id;
        } else {
            $vid = intval($v['id']);
            $conn->query("UPDATE product_variations SET color_id = $vColorId, option_id = $vOptionId, size_id = $vSizeId, sku = '$vSku', price = $dbPrice, original_price = $dbOriginalPrice, stock_quantity = $vStock, status = $vStatus WHERE id = $vid AND product_id = $product_id");
            $keepVarIds[] = $vid;
        }
    }

    // Delete removed variations
    $keepVarIdsStr = implode(',', $keepVarIds);
    if (!empty($keepVarIdsStr)) {
        $conn->query("DELETE FROM product_variations WHERE product_id = $product_id AND id NOT IN ($keepVarIdsStr)");
    } else {
        $conn->query("DELETE FROM product_variations WHERE product_id = $product_id");
    }

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Database Error: ' . $conn->error]);
}

$conn->close();
?>
