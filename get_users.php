<?php
include 'db.php'; // Make sure this includes your PDO connection setup

header("Content-Type: application/json");

try {
    // Prepare a SQL query to fetch all users
    $sql = "SELECT * FROM users";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(); // No need to pass $id since we're fetching all users
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if users were found
    if ($users) {
        echo json_encode($users);
    } else {
        // Respond with no users found
        echo json_encode(['message' => 'No users found']);
    }
} catch (PDOException $e) {
    // Handle any errors in fetching data
    http_response_code(500);
    echo json_encode(['message' => 'Database error: ' . $e->getMessage()]);
}
?>
