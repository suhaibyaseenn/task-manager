<?php
session_start();
include 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($username) || empty($email) || empty($password)) {
        $error = 'All fields are required.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } else {
        $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
        if (mysqli_num_rows($check) > 0) {
            $error = 'Email already registered.';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
            if (mysqli_query($conn, $query)) {
                $success = 'Account created successfully! You can now login.';
            } else {
                $error = 'Something went wrong. Please try again.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Task Manager</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="auth-container">
    <h1>Task Manager</h1>
    <div class="auth-box">
        <h2>Create Account</h2>

        <?php if ($error): ?>
            <div class="alert error"><?= $error ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert success"><?= $success ?></div>
        <?php endif; ?>

        <form action="register.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email address" required>
            <input type="password" name="password" placeholder="Password (min 6 characters)" required>
            <input type="password" name="confirm_password" placeholder="Confirm password" required>
            <button type="submit">Create Account</button>
        </form>

        <p class="auth-link">Already have an account? <a href="login.php">Login here</a></p>
    </div>
</div>

</body>
</html>