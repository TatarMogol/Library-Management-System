<?php
session_start();
require_once 'config.php';

// ======================
// REGISTER
// ======================
if (isset($_POST['register'])) {

    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role     = $_POST['role'];

    if ($role === 'admin') {
        // Check if admin exists
        $check = $conn->query("SELECT email FROM admin WHERE email='$email'");
        if ($check->num_rows > 0) {
            $_SESSION['register_error'] = "Admin already exists";
        } else {
            $conn->query("INSERT INTO admin (username, email, password) 
                         VALUES ('$username', '$email', '$password')") 
            or die($conn->error);
        }
    } else {
        // Check if user exists
        $check = $conn->query("SELECT email FROM users WHERE email='$email'");
        if ($check->num_rows > 0) {
            $_SESSION['register_error'] = "User already exists";
        } else {
            $conn->query("INSERT INTO users (name, email, password, role) 
                         VALUES ('$username', '$email', '$password', 'user')") 
            or die($conn->error);
        }
    }

    $_SESSION['active_form'] = 'login';
    header("Location: index.php");
    exit();
}

// ======================
// LOGIN
// ======================
if (isset($_POST['login'])) {

    $email    = $_POST['email'];
    $password = $_POST['password'];

    // ---------- ADMIN LOGIN ----------
    $admin = $conn->query("SELECT * FROM admin WHERE email='$email'");
    if ($admin->num_rows === 1) {
        $row = $admin->fetch_assoc();

        if (password_verify($password, $row['password']) || $password === $row['password']) {
            $_SESSION['email']    = $row['email'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role']     = 'admin';

            header("Location: admin_page.php");
            exit();
        }
    }

    // ---------- USER LOGIN ----------
    $user = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($user->num_rows === 1) {
        $row = $user->fetch_assoc();

        if (password_verify($password, $row['password']) || $password === $row['password']) {
            $_SESSION['email']    = $row['email'];
            $_SESSION['username'] = $row['name']; // <- FIXED from username to name
            $_SESSION['role']     = $row['role'];

            header("Location: user_page.php");
            exit();
        }
    }

    $_SESSION['login_error'] = "Invalid email or password";
    $_SESSION['active_form'] = 'login';
    header("Location: index.php");
    exit();
}
?>
