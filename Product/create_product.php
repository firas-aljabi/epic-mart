<?php
include 'db.php';

header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['name'], $data['price'], $data['category_id'], $data['photo'], $data['description'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Name, price, category ID, photo, and description are required.']);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO products (name, price, category_id, photo, description) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$data['name'], $data['price'], $data['category_id'], $data['photo'], $data['description']]);
    echo json_encode(['message' => 'Product created successfully']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Database error: ' . $e->getMessage()]);
}
?>
