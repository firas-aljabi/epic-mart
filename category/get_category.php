<?php
include 'db.php';

header("Content-Type: application/json");
$id = $_GET['id'] ?? '';

if (!$id) {
    http_response_code(400);
    echo json_encode(['message' => 'Category ID is required.']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT id, name, photo, description FROM category WHERE id = ?");
    $stmt->execute([$id]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($category) {
        echo json_encode($category);
    } else {
        http_response_code(404);
        echo json_encode(['message' => 'Category not found.']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Database error: ' . $e->getMessage()]);
}
