<?php
include 'db.php';

header("Content-Type: application/json");

$input = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $input['name'] ?? null; // Added null coalescing for safety
    $email = $input['email'] ?? null;
    $password = $input['password'] ?? null;
    $photo = $input['photo'] ?? null;

    if (!$name || !$email || !$password) {
        http_response_code(400); // Bad request
        echo json_encode(['message' => 'Name, email, and password are required.']);
        exit;
    }

    // Secure password hashing
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, photo, user_type) VALUES (?, ?, ?, ?, 'client')");
        $stmt->execute([$name, $email, $hashedPassword, $photo]);
        echo json_encode(['message' => 'User registered successfully']);
    } catch (PDOException $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(['message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['message' => 'Invalid request method.']);
}
?>
