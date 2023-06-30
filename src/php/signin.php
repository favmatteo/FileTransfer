<?php

require_once('connection.php');
header('Content-Type: application/json');

$email = $_POST['email'];
$password = $_POST['password'];

if(empty($email) || empty($password)) {
    echo json_encode(array("status" => "error", "message" => "Please fill in all fields!"));
    exit();
}

// check if email and password are correct
$stmt = $conn->prepare("SELECT * FROM user WHERE email = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();

if($stmt->rowCount() == 0) {
    echo json_encode(array("status" => "error", "message" => "Email does not exist!"));
    exit();
}

// check password
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if(!password_verify($password, $user['password'])) {
    echo json_encode(array("status" => "error", "message" => "Password is incorrect!"));
    exit();
}else{
    session_start();
    $_SESSION['user'] = $user;
    echo json_encode(array("status" => "success", "message" => "Logged in!"));
    exit();
}