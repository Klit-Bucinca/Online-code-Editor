<?php
header('Content-Type: application/json');
require 'connect.php';

$response = ['success' => false, 'prompts' => [], 'error' => ''];

try {
    // Check database connection
    if ($conn->connect_error) {
        throw new Exception("Database connection failed: " . $conn->connect_error);
    }

    // Query to fetch all prompts
    $query = "SELECT id, user_id, name, html, css, js FROM prompts ORDER BY id DESC";
    $result = $conn->query($query);

    if (!$result) {
        throw new Exception("Query failed: " . $conn->error);
    }

    // Fetch results
    while ($row = $result->fetch_assoc()) {
        $response['prompts'][] = [
            'id' => (int) $row['id'],
            'user_id' => (int) $row['user_id'],
            'name' => htmlspecialchars($row['name']),
            'html' => $row['html'],
            'css' => $row['css'],
            'js' => $row['js'],
        ];
    }

    $response['success'] = true;
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

// Close connection
$conn->close();

// Output JSON response
echo json_encode($response);
?>
