<?php
require_once('../inc/db.php');
require_once('../inc/image_helper.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $apartment = trim($_POST['apartment'] ?? '');
    $country = trim($_POST['country'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $postalCode = trim($_POST['postal_code'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $paymentMethod = trim($_POST['payment_method'] ?? 'COD');
    $totalAmount = floatval($_POST['total_amount'] ?? 0);
    $cartJson = $_POST['cart'] ?? '[]';
    $cart = json_decode($cartJson, true);

    if (empty($firstName) || empty($lastName) || empty($email) || empty($address) || empty($country) || empty($city) || empty($phone) || empty($cart)) {
        echo json_encode(['success' => false, 'error' => 'Please fill all required fields and ensure your cart is not empty.']);
        exit;
    }

    $paymentProofPath = null;
    if ($paymentMethod !== 'COD') {
        if (!isset($_FILES['payment_proof']) || $_FILES['payment_proof']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'error' => 'Please upload a valid payment proof screenshot.']);
            exit;
        }

        $uploadDir = '../uploads/payments/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = time() . '_' . uniqid() . '.webp';
        $targetFile = $uploadDir . $fileName;

        if (processAndSaveWebP($_FILES['payment_proof']['tmp_name'], $targetFile)) {
            $paymentProofPath = 'uploads/payments/' . $fileName;
        } else {
            echo json_encode(['success' => false, 'error' => 'Error uploading payment proof.']);
            exit;
        }
    }

    $conn->begin_transaction();

    try {
        $stmt = $conn->prepare("INSERT INTO orders (first_name, last_name, email, address, apartment, country, city, postal_code, phone, payment_method, payment_proof, total_amount, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')");
        $stmt->bind_param("sssssssssssd", $firstName, $lastName, $email, $address, $apartment, $country, $city, $postalCode, $phone, $paymentMethod, $paymentProofPath, $totalAmount);
        
        if (!$stmt->execute()) {
            throw new Exception("Error inserting order: " . $stmt->error);
        }
        
        $orderId = $stmt->insert_id;
        $stmt->close();

        $stmtDetails = $conn->prepare("INSERT INTO order_details (order_id, product_id, product_name, product_size, quantity, price, variation_id, product_color, product_option) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $calculatedTotal = 0;

        foreach ($cart as $item) {
            $productId = intval($item['id']);
            $productName = $item['name'];
            $productSize = $item['size'] ?? 'Standard';
            $quantity = intval($item['quantity']);
            
            $variationId = !empty($item['variationId']) ? intval($item['variationId']) : null;
            $color = !empty($item['color']) ? $item['color'] : null;
            $option = !empty($item['option']) ? $item['option'] : null;

            $actualPrice = 0;
            if ($variationId) {
                $varRes = $conn->query("SELECT price, stock_quantity FROM product_variations WHERE id = $variationId AND product_id = $productId AND status = 1");
                if($varRes && $varRes->num_rows > 0) {
                    $vRow = $varRes->fetch_assoc();
                    $actualPrice = floatval($vRow['price']);
                    
                    if(intval($vRow['stock_quantity']) < $quantity) {
                         throw new Exception("Not enough stock for $productName");
                    }
                    // Optional: Decrease stock here (not strictly requested but good practice)
                    // $conn->query("UPDATE product_variations SET stock_quantity = stock_quantity - $quantity WHERE id = $variationId");
                } else {
                     throw new Exception("Invalid variation for $productName");
                }
            } else {
                $prodRes = $conn->query("SELECT price, salePrice, sale, stock FROM products WHERE id = $productId");
                if($prodRes && $prodRes->num_rows > 0) {
                    $pRow = $prodRes->fetch_assoc();
                    $actualPrice = $pRow['sale'] ? floatval($pRow['salePrice']) : floatval($pRow['price']);
                } else {
                    throw new Exception("Invalid product $productName");
                }
            }
            
            $calculatedTotal += ($actualPrice * $quantity);

            $stmtDetails->bind_param("iissidiss", $orderId, $productId, $productName, $productSize, $quantity, $actualPrice, $variationId, $color, $option);
            if (!$stmtDetails->execute()) {
                throw new Exception("Error inserting order details: " . $stmtDetails->error);
            }
        }
        $stmtDetails->close();
        
        // Update the order total with securely calculated total
        $conn->query("UPDATE orders SET total_amount = $calculatedTotal WHERE id = $orderId");

        $conn->commit();
        echo json_encode(['success' => true, 'message' => 'Your order has been placed successfully.']);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'error' => 'Failed to process order: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}
?>
