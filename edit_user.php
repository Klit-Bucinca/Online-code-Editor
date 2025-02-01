<?php
include('connectadmin.php');

// Get JSON data from the request
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id'], $data['username'], $data['email'])) {
    $id = intval($data['id']);
    $username = $data['username'];
    $email = $data['email'];

    // Update the user's details
    $updateSql = "UPDATE regist SET Username = ?, Email = ? WHERE id = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("ssi", $username, $email, $id);

    if ($stmt->execute()) {
        echo "User updated successfully.";
    } else {
        echo "Error updating user: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid input data.";
}

$conn->close();
?>
