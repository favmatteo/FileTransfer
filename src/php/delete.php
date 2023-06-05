<?php

require_once('connection.php');
header('Content-Type: application/json');

session_start();

$id_file = $_POST['id_file'];
$id_user = $_SESSION['user']['id_user'];

$stmt = $conn->prepare("DELETE FROM file WHERE id_file = :id_file AND id_user = :id_user");
$stmt->bindParam(':id_file', $id_file);
$stmt->bindParam(':id_user', $id_user);
$stmt->execute();

if($stmt->rowCount() == 0) {
    echo json_encode(array("status" => "error", "message" => "No files found!"));
    exit();
}else{
    echo json_encode(array("status" => "success", "message" => "File deleted!"));
}
?>