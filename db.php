<?php
// db.php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "blog";

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
