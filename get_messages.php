<?php
include "db.php";
session_start();
$from = $_SESSION['userid'];
$to = $_GET['to'];

$res = $conn->query("SELECT * FROM messages WHERE 
    (sender_id=$from AND receiver_id=$to) OR 
    (sender_id=$to AND receiver_id=$from) ORDER BY timestamp ASC");

while ($row = $res->fetch_assoc()) {
    $class = ($row['sender_id'] == $from) ? "outgoing" : "incoming";
    echo "<div class='message $class'>{$row['message']}<br><small>{$row['timestamp']}</small></div>";
}
?>
