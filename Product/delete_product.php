<?php
include 'db.php';

header("Content-Type: application/json");
$id = $_GET['id'] ?? '';

if (!$id) {
    http_response_code(400);
    echo json_encode(['message' => 'Product ID is required.']);
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
    if ($stmt->rowCount()) {
        echo json_encode(['message' => 'Product deleted successfully']);
    } else {
        http_response_code(404);
        echo json_encode(['message' => 'Product not found or already deleted']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Database error: ' . $e->getMessage()]);
}
?>
