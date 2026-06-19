<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

$result = mysqli_query($conn, "SELECT * FROM tasks WHERE user_id='$user_id' ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
    <div class="nav-brand">Task Manager</div>
    <div class="nav-right">
        <span class="nav-user">👋 Welcome, <?= htmlspecialchars($username) ?></span>
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>
</nav>

<div class="container">
    <div class="form-box">
        <h2>Add New Task</h2>
        <form action="add_task.php" method="POST">
            <input type="text" name="title" placeholder="Task title" required>
            <textarea name="description" placeholder="Task description (optional)"></textarea>
            <button type="submit">Add Task</button>
        </form>
    </div>

    <div class="task-list">
        <h2>All Tasks</h2>
        <?php if (mysqli_num_rows($result) == 0): ?>
            <p class="no-tasks">No tasks yet. Add one above!</p>
        <?php else: ?>
            <?php while ($task = mysqli_fetch_assoc($result)): ?>
                <div class="task-card <?= $task['status'] ?>">
                    <div class="task-info">
                        <h3><?= htmlspecialchars($task['title']) ?></h3>
                        <p><?= htmlspecialchars($task['description']) ?></p>
                        <small>Created: <?= $task['created_at'] ?></small>
                    </div>
                    <div class="task-actions">
                        <?php if ($task['status'] == 'pending'): ?>
                            <a href="complete_task.php?id=<?= $task['id'] ?>" class="btn complete">✔ Complete</a>
                        <?php else: ?>
                            <span class="badge">✔ Done</span>
                        <?php endif; ?>
                        <a href="delete_task.php?id=<?= $task['id'] ?>" class="btn delete" onclick="return confirm('Delete this task?')">🗑 Delete</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</div>

</body>
</html>