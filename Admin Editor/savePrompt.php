<?php
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['name'], $data['html'], $data['css'], $data['js'], $data['user_id'])) {
    $name = $data['name'];
    $html = $data['html'];
    $css = $data['css'];
    $js = $data['js'];
    $user_id = $data['user_id'];

    $conn = new mysqli("localhost", "root", "", "user_database");
    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'error' => $conn->connect_error]);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO prompts (user_id, name, html, css, js) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $user_id, $name, $html, $css, $js);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
}
?>
