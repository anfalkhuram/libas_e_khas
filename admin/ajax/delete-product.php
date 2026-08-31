<?php
require_once('../../inc/db.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
    exit;
}

$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

if ($product_id === 0) {
    echo json_encode(['success' => false, 'error' => 'Invalid product ID.']);
    exit;
}

// Optional: Delete images from server
$stmtImg = $conn->prepare("SELECT main_image, hover_image FROM products WHERE id = ?");
$stmtImg->bind_param("i", $product_id);
$stmtImg->execute();
$res = $stmtImg->get_result();
if ($res && $res->num_rows > 0) {
    $row = $res->fetch_assoc();
    if ($row['main_image'] && file_exists('../../' . $row['main_image'])) {
        unlink('../../' . $row['main_image']);
    }
    if ($row['hover_image'] && file_exists('../../' . $row['hover_image'])) {
        unlink('../../' . $row['hover_image']);
    }
}
$stmtImg->close();

// Delete gallery images
$stmtGal = $conn->prepare("SELECT image_path FROM product_images WHERE product_id = ?");
$stmtGal->bind_param("i", $product_id);
$stmtGal->execute();
$galRes = $stmtGal->get_result();
if ($galRes && $galRes->num_rows > 0) {
    while($galRow = $galRes->fetch_assoc()) {
        if ($galRow['image_path'] && file_exists('../../' . $galRow['image_path'])) {
            unlink('../../' . $galRow['image_path']);
        }
    }
}
$stmtGal->close();

// Foreign keys should cascade or be deleted manually
$stmtDelGal = $conn->prepare("DELETE FROM product_images WHERE product_id = ?");
$stmtDelGal->bind_param("i", $product_id);
$stmtDelGal->execute();
$stmtDelGal->close();

$stmtDelProd = $conn->prepare("DELETE FROM products WHERE id = ?");
$stmtDelProd->bind_param("i", $product_id);

if ($stmtDelProd->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Database Error: ' . $stmtDelProd->error]);
}
$stmtDelProd->close();

$conn->close();
?>
