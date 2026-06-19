<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager — Organize Your Work</title>
    <link rel="stylesheet" href="landing.css">
</head>
<body>

<nav class="landing-nav">
    <div class="landing-brand">Task Manager</div>
    <div class="landing-nav-links">
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="dashboard.php" class="btn-nav">Go to Dashboard</a>
        <?php else: ?>
            <a href="login.php" class="btn-nav-text">Login</a>
            <a href="register.php" class="btn-nav">Sign Up</a>
        <?php endif; ?>
    </div>
</nav>

<section class="hero">
    <h1>Organize your work,<br>one task at a time.</h1>
    <p>A simple, fast task manager to keep your day on track — add, complete, and clear tasks in seconds.</p>
    <div class="hero-buttons">
        <a href="register.php" class="btn-primary">Get Started — It's Free</a>
        <a href="login.php" class="btn-secondary">Login</a>
    </div>
</section>

<section class="features">
    <h2>Everything you need, nothing you don't</h2>
    <div class="feature-grid">
        <div class="feature-card">
            <div class="feature-icon">🔐</div>
            <h3>Secure Login</h3>
            <p>Your account is protected with hashed passwords and session-based authentication.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">📝</div>
            <h3>Add Tasks Instantly</h3>
            <p>Create new tasks with a title and description in seconds — no clutter, no friction.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">✅</div>
            <h3>Track Progress</h3>
            <p>Mark tasks complete or delete them once you're done — your list, always up to date.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🔒</div>
            <h3>Private by Default</h3>
            <p>Every user only ever sees their own tasks. No exceptions.</p>
        </div>
    </div>
</section>

<footer class="landing-footer">
    <p>Built by <a href="https://github.com/suhaibyaseenn" target="_blank">Suhaib Yaseen</a></p>
    <a href="https://github.com/suhaibyaseenn/task-manager" target="_blank">View on GitHub</a>
</footer>

</body>
</html>