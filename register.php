<?php
require 'functions.php';
$csrf_token = generate_csrf_token();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
    <form action="process_register.php" method="POST">
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
        <label>Username</label>
        <input type="text" name="username" required>
        <label>Password</label>
        <input type="password" name="password" required>
        <button type="submit">Register</button>
    </form>
</body>
</html>
