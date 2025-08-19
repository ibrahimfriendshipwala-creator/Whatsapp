<?php
include "db.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $conn->query("INSERT INTO users (username, password) VALUES ('$username', '$password')");
    echo "<script>window.location.href='login.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sign Up - WhatsApp Clone</title>
    <style>
        body { margin:0; display:flex; align-items:center; justify-content:center; height:100vh; background:#e5ddd5; font-family:sans-serif; }
        form { background:white; padding:40px; border-radius:10px; box-shadow:0 0 15px rgba(0,0,0,0.2); width:300px; }
        h2 { margin-bottom:20px; color:#075e54; }
        input, button { width:100%; padding:12px; margin:10px 0; border-radius:5px; border:1px solid #ccc; font-size:14px; }
        button { background:#25D366; color:white; border:none; font-weight:bold; cursor:pointer; }
        a { color:#075e54; text-decoration:none; }
    </style>
</head>
<body>
<form method="post">
    <h2>Create Account</h2>
    <input name="username" placeholder="Username" required>
    <input name="password" type="password" placeholder="Password" required>
    <button type="submit">Sign Up</button>
    <p>Already have an account? <a href="login.php">Login</a></p>
</form>
</body>
</html>
