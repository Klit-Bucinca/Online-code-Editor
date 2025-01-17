<?php
require_once 'connect.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');
    $response = array('status' => '', 'message' => '');

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $phoneNumber = $_POST['phoneNumber'];
    $email = $_POST['email'];
    $message = $_POST['message']; 

    if (empty($firstName) || empty($lastName) || empty($email) || empty($message)) {
        $response['status'] = 'error';
        $response['message'] = "All fields are required.";
        echo json_encode($response);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO contact_form (first_name, last_name, phone_number, email, message) 
                            VALUES (?, ?, ?, ?, ?)");
    
    $stmt->bind_param("sssss", $firstName, $lastName, $phoneNumber, $email, $message);
    
    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = "Thank you for your message.";
    } else {
        $response['status'] = 'error';
        $response['message'] = "There was an error submitting your message.";
    }

    $stmt->close(); 
    $conn->close();
    
    echo json_encode($response);
}
?>