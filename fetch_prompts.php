<?php
session_start();
require "db.php";

header("Content-Type: application/json");

if (!isset($_SESSION["user_id"])) {
    echo json_encode(["error" => "User not authenticated"]);
    exit;
}

$userId = $_SESSION["user_id"];

$stmt = $pdo->prepare("SELECT id, name, html, css, js FROM prompts WHERE user_id = ? ORDER BY id");
$stmt->execute([$userId]);
$prompts = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($prompts);
?>
