<?php
include "db.php";
session_start();
$uid = $_SESSION['userid'];
$res = $conn->query("SELECT * FROM users WHERE id != $uid");
while ($row = $res->fetch_assoc()) {
    echo "<div class='user' onclick=\"selectUser({$row['id']}, '{$row['username']}')\">{$row['username']}</div>";
}
?>
