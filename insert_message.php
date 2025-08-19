<?php
include "db.php";
session_start();
$from = $_SESSION['userid'];
$to = $_POST['to'];
$msg = $conn->real_escape_string($_POST['message']);
$conn->query("INSERT INTO messages (sender_id, receiver_id, message) VALUES ($from, $to, '$msg')");
?>
