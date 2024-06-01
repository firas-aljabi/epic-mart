<?php
include 'db.php';

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['name']) || !isset($data['description']) || !isset($data['photo'])) {
    http_response_code(400);
    echo json_encode(['message' => 'All fields are required.']);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO category (name, photo, description) VALUES (?, ?, ?)");
    $stmt->execute([$data['name'], $data['photo'], $data['description']]);
    echo json_encode(['message' => 'Category created successfully']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Database error: ' . $e->getMessage()]);
}
