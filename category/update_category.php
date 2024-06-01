<?php
include 'db.php';

header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'] ?? '';

if (!$id || !isset($data['name']) || !isset($data['description']) || !isset($data['photo'])) {
    http_response_code(400);
    echo json_encode(['message' => 'All fields including ID are required.']);
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE category SET name = ?, photo = ?, description = ? WHERE id = ?");
    $stmt->execute([$data['name'], $data['photo'], $data['description'], $id]);
    echo json_encode(['message' => 'Category updated successfully']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Database error: ' . $e->getMessage()]);
}
