<?php
session_start();
include 'config.php';

$error = '';
$success = '';
$valid_token = false;
$token = isset($_GET['token']) ? $_GET['token'] : '';

// Validate token
if ($token) {
    $token_escaped = mysqli_real_escape_string($conn, $token);
    $result = mysqli_query($conn, "SELECT * FROM password_resets WHERE token='$token_escaped' AND expires_at > NOW()");
    $reset = mysqli_fetch_assoc($result);

    if ($reset) {
        $valid_token = true;
    } else {
        $error = 'This reset link is invalid or has expired.';
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $valid_token) {
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($new_password) || strlen($new_password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif ($new_password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } else {
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $email = mysqli_real_escape_string($conn, $reset['email']);

        mysqli_query($conn, "UPDATE users SET password='$hashed' WHERE email='$email'");
        mysqli_query($conn, "DELETE FROM password_resets WHERE email='$email'");

        $success = 'Password reset successfully! You can now login.';
        $valid_token = false;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Task Manager</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="auth-container">
    <h1>Task Manager</h1>
    <div class="auth-box">
        <h2>Reset Password</h2>

        <?php if ($error): ?>
            <div class="alert error"><?= $error ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert success"><?= $success ?></div>
            <p class="auth-link"><a href="login.php">← Back to Login</a></p>
        <?php elseif ($valid_token): ?>
            <form action="reset_password.php?token=<?= htmlspecialchars($token) ?>" method="POST">
                <input type="password" name="password" placeholder="New password (min 6 characters)" required>
                <input type="password" name="confirm_password" placeholder="Confirm new password" required>
                <button type="submit">Reset Password</button>
            </form>
        <?php else: ?>
            <?php if (!$error): ?>
                <div class="alert error">Invalid or missing reset token.</div>
            <?php endif; ?>
            <p class="auth-link"><a href="forgot_password.php">Request a new reset link</a></p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>