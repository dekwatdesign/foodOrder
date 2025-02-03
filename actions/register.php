<?php
require 'db.php';
require 'functions.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $csrf_token = $_POST['csrf_token'];

    if (!verify_csrf_token($csrf_token)) {
        die("CSRF Token Invalid!");
    }

    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $password]);

    header("Location: index.php");
}
?>
