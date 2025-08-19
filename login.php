<?php
include "db.php";
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $res = $conn->query("SELECT * FROM users WHERE username='$username'");
    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['userid'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            echo "<script>window.location.href='index.php';</script>";
            exit;
        }
    }
    $error = "Invalid credentials";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - WhatsApp Clone</title>
    <style>
        body { margin:0; display:flex; align-items:center; justify-content:center; height:100vh; background:#d9fdd3; font-family:sans-serif; }
        form { background:white; padding:40px; border-radius:10px; box-shadow:0 0 15px rgba(0,0,0,0.2); width:300px; }
        h2 { margin-bottom:20px; color:#075e54; }
        input, button { width:100%; padding:12px; margin:10px 0; border-radius:5px; border:1px solid #ccc; font-size:14px; }
        button { background:#128C7E; color:white; border:none; font-weight:bold; cursor:pointer; }
        a { color:#075e54; text-decoration:none; }
    </style>
</head>
<body>
<form method="post">
    <h2>Login</h2>
    <input name="username" placeholder="Username" required>
    <input name="password" type="password" placeholder="Password" required>
    <button type="submit">Login</button>
    <p>Don't have an account? <a href="signup.php">Sign up</a></p>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
</form>
</body>
</html>
