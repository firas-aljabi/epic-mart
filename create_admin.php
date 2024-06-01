<?php
require 'vendor/autoload.php';  // Ensure the Composer autoload for JWT library is included
include 'db.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

header("Content-Type: application/json");
$headers = getallheaders();
$authHeader = $headers['Authorization'] ?? '';

if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
    $token = $matches[1];
} else {
    http_response_code(401); // Unauthorized
    echo json_encode(['message' => 'Token not provided']);
    exit;
}

$key = "your_secret_key"; // This key should be the same one used to sign the JWT
try {
    $decoded = JWT::decode($token, new Key($key, 'HS256'));
    if ($decoded->type !== 'super_admin') {
        http_response_code(403); // Forbidden
        echo json_encode(['message' => 'Unauthorized access. Only super admins can perform this action.']);
        exit;
    }
} catch (Exception $e) {
    http_response_code(401); // Unauthorized
    echo json_encode(['message' => 'Invalid token: ' . $e->getMessage()]);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

$name = $input['name'] ?? null;
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
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, photo, user_type) VALUES (?, ?, ?, ?, 'admin')");
    $stmt->execute([$name, $email, $hashedPassword, $photo]);
    echo json_encode(['message' => 'Admin created successfully']);
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['message' => 'Database error: ' . $e->getMessage()]);
}
?>
