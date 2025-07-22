<?php

session_start();

$host = "localhost:3307";
$username = "root";
$password = "";
$dbname = "student_profile";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
