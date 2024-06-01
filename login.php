<?php
require 'vendor/autoload.php';
include 'db.php';

use Firebase\JWT\JWT;

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'] ?? null;
$password = $data['password'] ?? null;

if (!$email || !$password) {
    http_response_code(400); // Bad Request
    echo json_encode(['message' => 'Both email and password are required.']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT id, name, password, user_type FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user) {
        http_response_code(401); // Unauthorized
        echo json_encode(['message' => 'No user found with that email address.']);
        exit;
    }

    if (!password_verify($password, $user['password'])) {
        http_response_code(401); // Unauthorized
        echo json_encode(['message' => 'Password does not match.']);
        exit;
    }

    $key = "your_secret_key"; // Secret key for JWT
    $issuedAt = time();
    $expirationTime = $issuedAt + 3600; // jwt valid for 1 hour from the issued time
    $payload = [
        'iat' => $issuedAt,
        'exp' => $expirationTime,
        'userid' => $user['id'],
        'type' => $user['user_type']
    ];

    $jwt = JWT::encode($payload, $key, 'HS256');

    echo json_encode([
        'message' => 'Login successful',
        'user' => [
            'id' => $user['id'],
            'name' => $user['name'],
            'type' => $user['user_type']
        ],
        'token' => $jwt
    ]);
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['message' => 'Failed to connect to database: ' . $e->getMessage()]);
}
