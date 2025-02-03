<?php

session_start();
define('_WEBROOT_PATH_', '../');
define('_LOG_NAME_', 'action');
require './components/setup.php';
$conn = getDatabaseConnections()['default'];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $csrf_token = $_POST['csrf_token'];
    $ip = $_SERVER['REMOTE_ADDR'];

    if (!verify_csrf_token($csrf_token)) {
        die("CSRF Token Invalid!");
    }

    if (!check_login_attempts($conn, $ip)) {
        die("Too many login attempts. Please try again later.");
    }

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        record_login_attempt($conn, $ip, true);
        header("Location: dashboard.php");
        exit;
    } else {
        record_login_attempt($conn, $ip, false);
        die("Invalid username or password.");
    }
}

?>