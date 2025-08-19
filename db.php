<?php
$host = "localhost";
$user = "uagziilqywssc";
$pass = "81uzbkkkst0u";
$db = "dbgulr60qupkzw";

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
