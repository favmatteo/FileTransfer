<?php
require_once 'config.php';
$host = getenv("DB_HOST");
$dbname = getenv("DB_NAME");
$username = getenv("DB_USER");
$password = getenv("DB_PASS");
$port = getenv("DB_PORT");

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;port=$port", $username, $password);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}