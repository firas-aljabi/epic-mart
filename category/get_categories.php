<?php
include 'db.php';

header("Content-Type: application/json");

try {
    $stmt = $pdo->prepare("SELECT id, name, photo, description FROM category");
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($categories);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Database error: ' . $e->getMessage()]);
}
