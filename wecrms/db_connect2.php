<?php
$host = "localhost";
$user = "root";   // default in XAMPP
$pass = "";       // default empty in XAMPP
$db   = "employee_attendance"; 

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
