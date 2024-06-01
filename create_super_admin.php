<?php
include 'db.php'; 

try {
    $name = 'Super Admin';
    $email = 'superadmin@example.com';
    $password = 'yourStrongPassword';  
    $photo = '/path/to/photo.jpg';
    $userType = 'super_admin';

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password, user_type, photo) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $email, $hashedPassword, $userType, $photo]);

    echo "Super Admin created successfully.";
} catch (PDOException $e) {
    echo "Error creating Super Admin: " . $e->getMessage();
}
?>
