<?php
header('Content-Type: application/json');
require 'connect.php';

// Parse the incoming JSON data
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id']) && is_numeric($data['id'])) {
    $promptId = (int)$data['id'];

    try {
        // Delete the selected prompt
        $stmt = $conn->prepare("DELETE FROM prompts WHERE id = ?");
        $stmt->bind_param("i", $promptId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // **Reorder IDs after deletion**
            $conn->query("SET @count = 0");
            $conn->query("UPDATE prompts SET id = @count := @count + 1 ORDER BY id");
            $conn->query("ALTER TABLE prompts AUTO_INCREMENT = 1");

            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No prompt found with the given ID.']);
        }

        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid prompt ID.']);
}

$conn->close();
?>
