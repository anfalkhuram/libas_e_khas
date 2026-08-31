<?php
require_once('../../inc/db.php');

header('Content-Type: application/json');

$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

if ($category_id <= 0) {
    echo json_encode([]);
    exit;
}

$subCategories = [];
$stmt = $conn->prepare("SELECT id, name FROM sub_categories WHERE category_id = ? AND status = 1 ORDER BY name ASC");
if ($stmt) {
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $subCategories[] = $row;
    }
    $stmt->close();
}

echo json_encode($subCategories);
?>
