<?php
require_once 'connect.php';

header('Content-Type: application/json');
$response = array('status' => '', 'message' => '');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    
 
    $target_dir = "Images/slider/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    
   
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {

        $stmt = $conn->prepare("INSERT INTO slider_content (title, description, image_path) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $description, $target_file);
        
        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = "New slide has been added successfully!";
        } else {
            $response['status'] = 'error';
            $response['message'] = "Error adding slide to database.";
        }
        $stmt->close();
    } else {
        $response['status'] = 'error';
        $response['message'] = "Error uploading file.";
    }
    
    echo json_encode($response);
}
?> 