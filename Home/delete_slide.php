<?php
require_once 'connect.php';

header('Content-Type: application/json');
$response = array('status' => '', 'message' => '');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    

    $stmt = $conn->prepare("SELECT image_path FROM slider_content WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $slide = $result->fetch_assoc();
    
    if ($slide) {
        
        if (file_exists($slide['image_path'])) {
            unlink($slide['image_path']);
        }
        
       
        $stmt = $conn->prepare("DELETE FROM slider_content WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = "Slide deleted successfully!";
        } else {
            $response['status'] = 'error';
            $response['message'] = "Error deleting slide from database.";
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = "Slide not found.";
    }
    
    $stmt->close();
    echo json_encode($response);
}
?> 