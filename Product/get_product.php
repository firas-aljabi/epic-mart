<?php
include 'db.php';

header("Content-Type: application/json");

// Retrieve the product ID from query string
$id = $_GET['id'] ?? '';

// Check if the ID is provided
if (!$id) {
    http_response_code(400);
    echo json_encode(['message' => 'Product ID is required.']);
    exit;
}

try {
    // Prepare and execute the query to fetch the product
    $stmt = $pdo->prepare("SELECT id, name, price, category_id FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if a product was found
    if ($product) {
        echo json_encode($product);
    } else {
        http_response_code(404);
        echo json_encode(['message' => 'Product not found.']);
    }
} catch (PDOException $e) {
    // Handle any potential database errors
    http_response_code(500);
    echo json_encode(['message' => 'Database error: ' . $e->getMessage()]);
}
?>
