<?php
// index.php
session_start();
require 'config.php'; // Use the one connection from here

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $admin['id'];
        header("Location: admindashboard.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}

?>



<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-container">
        <img src="./University_of_Pangasinan_logo (1).png" alt="Logo" class="logo">
        <h2>UPang Registrar</h2>
        <?php if (!empty($error)) echo "<p class='error-message'>$error</p>"; ?>
        <form method="post">
            <label>Username</label>
            <input type="text" name="username" placeholder="Username" required>
            <label>Password</label>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Log in</button>
        </form>
        <a href="#" class="forgot-password">Forgot Password?</a>
    </div>
</body>
</html>
