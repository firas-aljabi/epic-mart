<?php
include 'db.php';

header("Content-Type: application/json");

try {
    $stmt = $pdo->query("SELECT id, name, price, category_id FROM products");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($products);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Database error: ' . $e->getMessage()]);
}
?>
