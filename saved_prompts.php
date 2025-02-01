<?php
include 'connectadmin.php'; // Include your database connection


// Fetch saved prompts with the user's name and ID
$query = "
    SELECT 
        prompts.id AS prompt_id, 
        users.id AS user_id, 
        users.Username AS username, 
        prompts.name AS prompt_name, 
        prompts.html, 
        prompts.css, 
        prompts.js
    FROM prompts
    JOIN regist AS users ON prompts.user_id = users.id
";
$result = $conn->query($query);

if (!$result) {
    die("Error fetching saved prompts: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saved Prompts</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link your stylesheet if necessary -->
</head>
<body>
    <h1>Saved Prompts</h1>
    <table border="1" cellspacing="0" cellpadding="10">
        <thead>
            <tr>
                <th>Prompt ID</th>
                <th>User ID</th>
                <th>Username</th>
                <th>Prompt Name</th>
                <th>HTML</th>
                <th>CSS</th>
                <th>JS</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['prompt_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['prompt_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['html']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['css']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['js']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No saved prompts found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
