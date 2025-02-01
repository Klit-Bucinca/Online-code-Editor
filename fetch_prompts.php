<?php
session_start();
require "db.php"; // Database connection

header("Content-Type: application/json");

if (!isset($_SESSION["user_id"])) {
    echo json_encode(["error" => "User not authenticated"]);
    exit;
}

$userId = $_SESSION["user_id"];

$stmt = $conn->prepare("SELECT id, name, html, css, js FROM prompts WHERE user_id = ? ORDER BY id");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$prompts = [];
while ($row = $result->fetch_assoc()) {
    $prompts[] = $row;
}

echo json_encode($prompts);
$stmt->close();
$conn->close();
?>
