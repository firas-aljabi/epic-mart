<?php
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$name = $data['name'] ?? null; // Added null coalescing for safety
$email = $data['email'] ?? null;
$password = $data['password'] ?? null;

if (!$name || !$email || !$password) {
    http_response_code(400); // Bad Request
    echo json_encode(['message' => 'All fields are required.']);
    exit;
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Proper password hashing

$sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$name, $email, $hashedPassword]);

echo json_encode(['message' => 'User created successfully']);
?>
