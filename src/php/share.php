<?php

require_once('connection.php');
header('Content-Type: application/json');

$id_file = $_POST['id_file'];
$users = $_POST['users'];


foreach ($users as &$user){
    $stmt = $conn->prepare("INSERT INTO shared (id_file, id_user) VALUES (:id_file, :id_user)");
    $stmt->bindParam(':id_file', $id_file);
    $stmt->bindParam(':id_user', $user);
    $stmt->execute();

    if($stmt->rowCount() == 0) {
        echo json_encode(array("status" => "error", "message" => "No files found!"));
        exit();
    }else{
        echo json_encode(array("status" => "success", "message" => "File shared with $user!"));
    }
}


?>