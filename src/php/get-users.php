<?php

require_once(__DIR__ . 'connection.php');
header('Content-Type: application/json');


session_start();
$id_user = $_SESSION['user']['id_user'];
$stmt = $conn->prepare("SELECT * FROM user WHERE id_user != :id_user");
$stmt->bindParam(':id_user', $id_user);
$stmt->execute();

if($stmt->rowCount() == 0) {
    echo json_encode(array("status" => "error", "message" => "No user found!"));
    exit();
}

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode(array("status" => "success", "users" => $users));


?>