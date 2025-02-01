<?php
session_start();
require 'db.php'; // Database connection file

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch logged-in user's details
$stmt = $pdo->prepare("SELECT Username FROM regist WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
$username = $user ? htmlspecialchars($user['Username']) : 'Unknown User';

// Fetch saved prompts
$stmt = $pdo->prepare("SELECT id, name, html, css, js FROM prompts WHERE user_id = ?");
$stmt->execute([$user_id]);
$prompts = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code Editor</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
<div class="buttons-row">
    <button id="navbar-toggle" class="navbar-toggle">☰</button>
    <button id="toggle-layout" class="layout-toggle">Toggle Layout</button>
</div>
<div class="container">
    <div class="navbar">
        <button id="navbar-close" class="navbar-close">✕</button>
        <h2>Saved Prompts</h2>
        <div class="saved-prompts">
            <?php foreach ($prompts as $prompt): ?>
                <div class="prompt" data-id="<?= $prompt['id'] ?>">
                    <span><?= htmlspecialchars($prompt['name']) ?></span>
                    <button class="delete-btn" onclick="deletePrompt(<?= $prompt['id'] ?>)">Delete</button>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="save-area">
            <input type="text" placeholder="Prompt name" id="prompt-name">
            <button id="save-prompt">Save</button>
        </div>
        <div class="user-info" id="user-button">
            <span class="username"><?= $username ?></span>
            <div id="user-dropdown" class="user-dropdown hidden">
                <a href="Home/Home.html">Go to Home Page</a>
                <a href="logout.php">Sign Out</a>
            </div>
        </div>
    </div>
    <div class="main layout-vertical-left">
        <div class="input-area">
            <textarea id="html-input" placeholder="HTML Code"></textarea>
            <textarea id="css-input" placeholder="CSS Code"></textarea>
            <textarea id="js-input" placeholder="JavaScript Code"></textarea>
        </div>
        <div class="output">
            <iframe id="output" style="width: 100%; height: 100%; border: none;"></iframe>
        </div>      
    </div>
</div>
<script src="script.js"></script>
</body>
</html>
