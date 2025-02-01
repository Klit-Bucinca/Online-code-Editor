<?php
include('connectadmin.php');

// Check if ID is provided
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Delete the user
    $deleteSql = "DELETE FROM regist WHERE id = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        // Reorder IDs
        $reorderSql = "SET @count = 0; 
                       UPDATE regist SET id = @count:= @count + 1; 
                       ALTER TABLE regist AUTO_INCREMENT = 1;";
        if ($conn->multi_query($reorderSql)) {
            echo "User deleted and IDs reordered successfully.";
        } else {
            echo "User deleted, but failed to reorder IDs: " . $conn->error;
        }
    } else {
        echo "Error deleting user: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request. No user ID provided.";
}

$conn->close();
?>
