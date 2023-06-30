<?php

require_once(__DIR__ . 'connection.php');
header('Content-Type: application/json');

session_start();

$id_file = $_POST['id_file'];
$id_user = $_SESSION['user']['id_user'];
if(!isset($id_file)) {
    echo json_encode(array("status" => "error", "message" => "No file selected!"));
    exit();
}

$stmt = $conn->prepare("SELECT * FROM file WHERE id_file = :id_file");
$stmt->bindParam(':id_file', $id_file);
$stmt->execute();

if($stmt->rowCount() == 0) {
    echo json_encode(array("status" => "error", "message" => "File not found!"));
    exit();
}

$file = $stmt->fetch(PDO::FETCH_ASSOC);
$file['file'] = base64_encode($file['file']);
echo json_encode(array("status" => "success", "file" => $file));


?>