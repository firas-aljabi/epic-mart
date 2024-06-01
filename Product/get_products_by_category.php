<?php
include 'db.php';

header("Content-Type: application/json");
// $id = $_GET['id'] ?? '';
// Retrieve the category ID from the query string
// $category_id = $_GET['id'] ?? '';
$data = json_decode(file_get_contents("php://input"), true);
$category_id = $data['id'] ?? '';


// Check if the category ID is provided
if (!$category_id) {
    http_response_code(400);
    echo json_encode(['message' => 'Category ID is required.']);
    exit;
}

try {
    // Prepare and execute the query to fetch products by category ID
    $stmt = $pdo->prepare("SELECT id, name, price, photo, description FROM products WHERE category_id = ?");
    $stmt->execute([$category_id]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if any products were found
    if ($products) {
        echo json_encode($products);
    } else {
        http_response_code(404);
        echo json_encode(['message' => 'No products found for this category.']);
    }
} catch (PDOException $e) {
    // Handle any potential database errors
    http_response_code(500);
    echo json_encode(['message' => 'Database error: ' . $e->getMessage()]);
}
?>
