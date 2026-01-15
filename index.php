<?php
session_start();

$errors = [
    'login' => $_SESSION['login_error'] ?? '',
    'register' => $_SESSION['register_error'] ?? ''
];

$activeForm = $_SESSION['active_form'] ?? 'login';

function showError($error)
{
    return !empty($error) ? "<p class='error_message'>$error</p>" : '';
}

function isActiveForm($formName, $activeForm)
{
    return $formName === $activeForm ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login / Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <!-- LOGIN -->
    <div class="form-box <?= isActiveForm('login', $activeForm); ?>" id="login-form">
        <form action="login_register.php" method="post">
            <h2>Login</h2>
            <?= showError($errors['login']); ?>

            <input type="email" name="email" placeholder="Email" autocomplete="off" required>
            <input type="password" name="password" autocomplete="new-password" placeholder="Password" required>

            <button type="submit" name="login">LOGIN</button>
            <p>Don’t have an account?
                <a href="#" onclick="showForm('register-form')">Register</a>
            </p>
        </form>
    </div>

    <!-- REGISTER -->
    <div class="form-box <?= isActiveForm('register', $activeForm); ?>" id="register-form">
        <form action="login_register.php" method="post" autofill="off">
            <h2>Register</h2>
            <?= showError($errors['register']); ?>

            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>

            <select name="role" required>
                <option value="">--select role--</option>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>

            <button type="submit" name="register">REGISTER</button>
            <p>Already registered?
                <a href="#" onclick="showForm('login-form')">Login</a>
            </p>
        </form>
    </div>

</div>

<script src="script.js"></script>
</body>
</html>
