<?php
require_once('../inc/db.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = intval($_POST['product_id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $rating = intval($_POST['rating'] ?? 0);
    $review_text = trim($_POST['review_text'] ?? '');
    
    if ($product_id <= 0 || empty($name) || empty($email) || $rating <= 0 || empty($review_text)) {
        echo json_encode(['success' => false, 'error' => 'All fields are required.']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO reviews (product_id, name, email, rating, review_text, status) VALUES (?, ?, ?, ?, ?, 0)");
    $stmt->bind_param("issis", $product_id, $name, $email, $rating, $review_text);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Review submitted successfully. It will be visible after approval.']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Database error: ' . $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}
?>
