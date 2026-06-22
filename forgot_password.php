<?php
session_start();
include 'config.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        // Generate a secure token
        $token = bin2hex(random_bytes(32));
        $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Delete any existing reset tokens for this email
        mysqli_query($conn, "DELETE FROM password_resets WHERE email='$email'");

        // Store the new token
        mysqli_query($conn, "INSERT INTO password_resets (email, token, expires_at) VALUES ('$email', '$token', '$expires_at')");

        // Send the email
        $reset_link = "http://localhost/task-manager/reset_password.php?token=$token";

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = MAIL_USERNAME;   // replace with your Gmail
            $mail->Password = MAIL_PASSWORD;       // replace with your App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom(MAIL_USERNAME, 'Task Manager');
            $mail->addAddress($email);
            $mail->Subject = 'Password Reset Request';
            $mail->Body = "Hi {$user['username']},\n\nClick the link below to reset your password. This link expires in 1 hour.\n\n$reset_link\n\nIf you didn't request this, ignore this email.";

            $mail->send();
            $success = 'Password reset link sent! Check your email.';
        } catch (Exception $e) {
            $error = 'Mailer Error: ' . $mail->ErrorInfo;
        }
    } else {
        // Don't reveal whether email exists or not (security best practice);
        $success = 'If that email exists, a reset link has been sent.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | Task Manager</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="auth-container">
    <h1>Task Manager</h1>
    <div class="auth-box">
        <h2>Forgot Password</h2>

        <?php if ($error): ?>
            <div class="alert error"><?= $error ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert success"><?= $success ?></div>
        <?php else: ?>
            <p style="color:#777; font-size:0.9rem; margin-bottom:15px;">
                Enter your email address and we'll send you a link to reset your password.
            </p>
            <form action="forgot_password.php" method="POST">
                <input type="email" name="email" placeholder="Email address" required>
                <button type="submit">Send Reset Link</button>
            </form>
        <?php endif; ?>

        <p class="auth-link"><a href="login.php">← Back to Login</a></p>
    </div>
</div>

</body>
</html>