<?php

    $servername = "localhost";
    $username = "root";
    $password = ""; 
    $dbname = "code_editor_db"; 

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $aboutUsQuery = "SELECT content FROM static_content WHERE section_name = 'about_us'";
    $aboutUsResult = $conn->query($aboutUsQuery);
    $aboutUsContent = $aboutUsResult->fetch_assoc()['content'] ?? "Default About Us text.";
    
    
    $usesQuery = "SELECT content FROM static_content WHERE section_name = 'uses'";
    $usesResult = $conn->query($usesQuery);
    $usesContent = $usesResult->fetch_assoc()['content'] ?? "Default Uses text.";


?>