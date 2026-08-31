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

// Get current product status
$stmt = $conn->prepare("SELECT status FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$res = $stmt->get_result();
if ($res && $res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $current_status = intval($row['status']);
    $new_status = ($current_status === 1) ? 0 : 1;
    
    // Update status
    $stmtUpd = $conn->prepare("UPDATE products SET status = ? WHERE id = ?");
    $stmtUpd->bind_param("ii", $new_status, $product_id);
    if ($stmtUpd->execute()) {
        // Calculate effective status
        $effSql = "SELECT p.status, c.status as cat_status, s.status as subcat_status 
                   FROM products p 
                   LEFT JOIN categories c ON p.category_id = c.id 
                   LEFT JOIN sub_categories s ON p.sub_category_id = s.id 
                   WHERE p.id = ?";
        $stmtEff = $conn->prepare($effSql);
        $stmtEff->bind_param("i", $product_id);
        $stmtEff->execute();
        $effRes = $stmtEff->get_result();
        $effective_status = 0;
        if ($effRes && $effRes->num_rows > 0) {
            $effRow = $effRes->fetch_assoc();
            $p_stat = intval($effRow['status']);
            $c_stat = isset($effRow['cat_status']) ? intval($effRow['cat_status']) : 1;
            $s_stat = isset($effRow['subcat_status']) ? intval($effRow['subcat_status']) : 1;
            $effective_status = ($p_stat === 1 && $c_stat === 1 && $s_stat === 1) ? 1 : 0;
        }
        $stmtEff->close();
        
        echo json_encode(['success' => true, 'new_status' => $new_status, 'effective_status' => $effective_status]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Database Error: ' . $stmtUpd->error]);
    }
    $stmtUpd->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Product not found.']);
}
$stmt->close();
$conn->close();
?>
