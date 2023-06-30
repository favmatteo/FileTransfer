<?php

require_once(__DIR__ . 'connection.php');
header('Content-Type: application/json');
ini_set('upload_max_filesize', getenv("MAX_FILE_SIZE"));

if(getenv("NEW_FILE") == "false") {
    echo json_encode(array("status" => "error", "message" => "New file uploads are disabled!"));
    exit();
}

$file = $_FILES['file'];
session_start();

$id_user = $_SESSION['user']['id_user'];
if(!isset($id_user)) {
    echo json_encode(array("status" => "error", "message" => "Please login!"));
    exit();
}

if (!is_uploaded_file($file['tmp_name'])) {
    echo json_encode(array("status" => "error", "message" => "Please upload a file!"));
    exit();
}

$name = $file['name'];
$full_path = $file['full_path'];
$type = $file['type'];
$tmp_name = $file['tmp_name'];
$error = $file['error'];
$size = $file['size'];

if($error != 0) {
    echo json_encode(array("status" => "error", "message" => "Error uploading file!"));
    exit();
}

$fileContent = file_get_contents($tmp_name);

$stmt = $conn->prepare("INSERT INTO file (title, file, size, type, id_user) VALUES (:name, :file, :size ,:type, :id_user)");
$stmt->bindParam(':name', $name);
$stmt->bindParam(':file', $fileContent);
$stmt->bindParam(':size', $size);
$stmt->bindParam(':type', $type);
$stmt->bindParam(':id_user', $id_user);
$stmt->execute();

echo json_encode(array("status" => "success", "message" => "File uploaded!"));