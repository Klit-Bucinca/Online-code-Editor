<?php
session_start();
require 'db.php'; // Include your database connection

header("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Not logged in"]);
    exit;
}

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id'])) {
    echo json_encode(["success" => false, "message" => "Invalid input"]);
    exit;
}

$promptId = intval($data['id']);

// Step 1: Delete the selected prompt
$stmt = $pdo->prepare("DELETE FROM prompts WHERE id = ? AND user_id = ?");
if ($stmt->execute([$promptId, $user_id])) {
    // Step 2: Reorder the IDs to maintain sequential numbering
    $pdo->query("SET @count = 0;");
    $pdo->query("UPDATE prompts SET id = @count:= @count + 1 WHERE user_id = $user_id ORDER BY id;");
    $pdo->query("ALTER TABLE prompts AUTO_INCREMENT = 1;");
    
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Error deleting prompt."]);
}

$stmt->closeCursor();
$pdo = null;
?>
