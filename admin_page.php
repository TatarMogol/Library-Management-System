<?php
session_start();

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin</title>
</head>
<body>
    <h1>Welcome Admin <?= htmlspecialchars($_SESSION['username']); ?></h1>
    <a href="logout.php">Logout</a>
</body>
</html>
