<?php
include 'db.php';

header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id'], $data['name'], $data['price'], $data['category_id'], $data['photo'], $data['description'])) {
    http_response_code(400);
    echo json_encode(['message' => 'All fields (id, name, price, category ID, photo, and description) are required.']);
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE products SET name = ?, price = ?, category_id = ?, photo = ?, description = ? WHERE id = ?");
    $stmt->execute([$data['name'], $data['price'], $data['category_id'], $data['photo'], $data['description'], $data['id']]);
    if ($stmt->rowCount()) {
        echo json_encode(['message' => 'Product updated successfully']);
    } else {
        http_response_code(404);
        echo json_encode(['message' => 'Product not found']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Database error: ' . $e->getMessage()]);
}
?>
