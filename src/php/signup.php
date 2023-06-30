<?php

// import the connection variables
require_once('connection.php');
require_once 'config.php';

header('Content-Type: application/json');

if(getenv("NEW_USER") == "false") {
    echo json_encode(array("status" => "error", "message" => "New user registrations are disabled!"));
    exit();
}

$email = $_POST['email'];
$password = $_POST['password'];

if(empty($email) || empty($password)) {
    echo json_encode(array("status" => "error", "message" => "Please fill in all fields!"));
    exit();
}

// check if email already exists
$stmt = $conn->prepare("SELECT * FROM user WHERE email = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();

if($stmt->rowCount() > 0) {
    echo json_encode(array("status" => "error", "message" => "Email already exists!"));
    exit();
}

// hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO user (email, password, username) VALUES (:email, :password, :username)");
$stmt->bindParam(':email', $email);
$stmt->bindParam(':password', $hashed_password);
$username = explode("@", $email)[0];
$stmt->bindParam(':username', $username);

$stmt->execute();

if($stmt->errorCode() != 0) {
    echo json_encode(array("status" => "error", "message" => "Something went wrong!"));
    exit();
}

echo json_encode(array("status" => "success", "message" => "Account created!"));