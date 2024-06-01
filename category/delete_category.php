<?php
include 'db.php';

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'] ?? '';
if (!$id) {
    http_response_code(400);
    echo json_encode(['message' => 'Category ID is required.']);
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM category WHERE id = ?");
    $stmt->execute([$id]);
    if ($stmt->rowCount()) {
        echo json_encode(['message' => 'Category deleted successfully']);
    } else {
        http_response_code(404);
        echo json_encode(['message' => 'Category not found or already deleted']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Database error: ' . $e->getMessage()]);
}
