<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Not logged in"]);
    exit;
}

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['name'], $data['html'], $data['css'], $data['js'])) {
    echo json_encode(["success" => false, "message" => "Invalid input"]);
    exit;
}

$stmt = $pdo->prepare("INSERT INTO prompts (user_id, name, html, css, js) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$user_id, $data['name'], $data['html'], $data['css'], $data['js']]);

echo json_encode(["success" => true, "id" => $pdo->lastInsertId()]);
?>
