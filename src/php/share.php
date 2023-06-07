<?php

require_once('connection.php');
header('Content-Type: application/json');

$id_file = $_POST['id_file'];
$users = $_POST['users'];


foreach ($users as &$user){
    // check if the file is already shared with the user
    $stmt = $conn->prepare("SELECT * FROM shared WHERE id_file = :id_file AND id_user = :id_user");
    $stmt->bindParam(':id_file', $id_file);
    $stmt->bindParam(':id_user', $user);
    $stmt->execute();

    // if yes, skip
    if($stmt->rowCount() > 0) {
        continue;
    }
    // if not, share the file with the user
    $stmt = $conn->prepare("INSERT INTO shared (id_file, id_user) VALUES (:id_file, :id_user)");
    $stmt->bindParam(':id_file', $id_file);
    $stmt->bindParam(':id_user', $user);
    $stmt->execute();

    if($stmt->rowCount() == 0) {
        echo json_encode(array("status" => "error", "message" => "No files found!"));
        exit();
    }
    
}

echo json_encode(array("status" => "success", "message" => "File shared successfully!"));

$stmt = $conn->prepare("DELETE FROM shared WHERE id_file = :id_file AND id_user NOT IN (".implode(',', $users).")");
$stmt->bindParam(':id_file', $id_file);
$stmt->execute();



?>