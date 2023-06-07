<?php

require_once('connection.php');
header('Content-Type: application/json');

$id_file = $_POST['id_file'];

// get all users who have access to the file
$stmt = $conn->prepare("SELECT distinct id_user FROM shared WHERE id_file = :id_file");
$stmt->bindParam(':id_file', $id_file);
$stmt->execute();

if($stmt->rowCount() == 0) {
    echo json_encode(array("status" => "error", "message" => "No shared user found!"));
    exit();
}

// return the result
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode(array("status" => "success", "users" => $users));

?>