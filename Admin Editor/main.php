<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="main.css">
  <title>Code Editor</title>
</head>
<body>
  <div class="container">
    <div class="navbar">
      <h2>Saved Prompts</h2>
      <div class="saved-prompts">
        <!-- Populated dynamically by getPrompts.php -->
      </div>
    </div>
    <div class="main">
      <div class="input-area">
        <div class="save-area">
          <input type="text" id="prompt-name" placeholder="Enter prompt name">
          <select id="user-select">
            <option value="">Select a user</option>
            <?php
              // Fetch users dynamically
              $conn = new mysqli("localhost", "root", "", "user_database");
              if ($conn->connect_error) {
                  die("Connection failed: " . $conn->connect_error);
              }
              $result = $conn->query("SELECT id, Username FROM regist");
              while ($row = $result->fetch_assoc()) {
                  echo "<option value='{$row['id']}'>{$row['Username']}</option>";
              }
              $conn->close();
            ?>
          </select>
          <button id="save-prompt">Save Prompt</button>
        </div>
        <textarea id="html-input" placeholder="HTML"></textarea>
        <textarea id="css-input" placeholder="CSS"></textarea>
        <textarea id="js-input" placeholder="JavaScript"></textarea>
      </div>
      <div class="output">
        <iframe id="output" style="width: 100%; height: 100%; border: none;"></iframe>
      </div>
    </div>
  </div>
  <script src="script.js"></script>
</body>
</html>
