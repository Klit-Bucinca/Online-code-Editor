<?php
require_once 'connect.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $phoneNumber = $_POST['phoneNumber'];
    $email = $_POST['email'];
    $message = $_POST['message']; 

    if (empty($firstName) || empty($lastName) || empty($email) || empty($message)) {
        echo "All fields are required.";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO contact_form (first_name, last_name, phone_number, email, message) 
                            VALUES (?, ?, ?, ?, ?)");

    
    $stmt->bind_param("sssss", $firstName, $lastName, $phoneNumber, $email, $message);

    
    if ($stmt->execute()) {
        echo "Thank you for your message.";
    } else {
        echo "There was an error submitting your message.";
    }

    $stmt->close(); 
    $conn->close();  
}
?>