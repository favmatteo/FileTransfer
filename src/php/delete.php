<?php

require_once('connection.php');
header('Content-Type: application/json');

session_start();

$id_file = $_POST['id_file'];

$stmt = $conn->prepare("DELETE FROM shared WHERE id_file = :id_file");
$stmt->bindParam(':id_file', $id_file);
$stmt->execute();

$stmt = $conn->prepare("DELETE FROM file WHERE id_file = :id_file");
$stmt->bindParam(':id_file', $id_file);
$stmt->execute();

if($stmt->rowCount() == 0) {
    echo json_encode(array("status" => "error", "message" => "No files found!"));
    exit();
}else{
    echo json_encode(array("status" => "success", "message" => "File deleted!"));
}
?>