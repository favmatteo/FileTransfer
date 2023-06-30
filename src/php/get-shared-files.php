<?php

require_once(__DIR__ . 'connection.php');
header('Content-Type: application/json');

session_start();
$id_user = $_SESSION['user']['id_user'];
$stmt = $conn->prepare("SELECT id_file FROM shared WHERE id_user = :id_user");
$stmt->bindParam(':id_user', $id_user);
$stmt->execute();

if($stmt->rowCount() == 0) {
    echo json_encode(array("status" => "error", "message" => "No shared file found!"));
    exit();
}

// for each file, get the file info
$files = [];
foreach ($stmt as $row) {
    $id_file = $row['id_file'];
    $stmt = $conn->prepare("SELECT id_file, title, size, type, id_user FROM file WHERE id_file = :id_file");
    $stmt->bindParam(':id_file', $id_file);
    $stmt->execute();

    $file = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // substitute the id with the username of the user who shared the file
    $id_user = $file[0]['id_user'];
    $stmt = $conn->prepare("SELECT username FROM user WHERE id_user = :id_user");
    $stmt->bindParam(':id_user', $id_user);
    $stmt->execute();
    $file[0]['id_user'] = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['username'];


    array_push($files, $file);
}

echo json_encode(array("status" => "success", "files" => $files));



?>