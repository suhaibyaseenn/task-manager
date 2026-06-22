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
$total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM tasks WHERE user_id='$user_id'"))['count'];
$pending = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM tasks WHERE user_id='$user_id' AND status='pending'"))['count'];
$completed = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM tasks WHERE user_id='$user_id' AND status='completed'"))['count'];
$overdue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM tasks WHERE user_id='$user_id' AND status='pending' AND due_date < CURDATE()"))['count'];
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
            <select name="priority">
                <option value="low">Low Priority</option>
                <option value="medium">Medium Priority</option>
                <option value="high">High Priority</option>
            </select>
            <input type="date" name="due_date">
            <button type="submit">Add Task</button>
            
        </form>
    </div>
    <div class="stats-bar">
    <div class="stat-card">
        <span class="stat-number"><?= $total ?></span>
        <span class="stat-label">Total Tasks</span>
    </div>
    <div class="stat-card">
        <span class="stat-number pending"><?= $pending ?></span>
        <span class="stat-label">Pending</span>
    </div>
    <div class="stat-card">
        <span class="stat-number completed"><?= $completed ?></span>
        <span class="stat-label">Completed</span>
    </div>
    <div class="stat-card">
        <span class="stat-number overdue"><?= $overdue ?></span>
        <span class="stat-label">Overdue</span>
    </div>
    </div>
    <div class="task-list">
        <h2>All Tasks</h2>
        <?php if (mysqli_num_rows($result) == 0): ?>
            <p class="no-tasks">No tasks yet. Add one above!</p>
        <?php else: ?>
           <?php while ($task = mysqli_fetch_assoc($result)): ?>
    <?php
        $due = !empty($task['due_date']) ? new DateTime($task['due_date']) : null;
        $today = new DateTime('today');
        $is_overdue = $due && $task['status'] == 'pending' && $due < $today;
    ?>
    <div class="task-card <?= $task['status'] ?> <?= $is_overdue ? 'task-overdue' : '' ?>">
        <div class="task-content">
            <div class="task-info">
                <h3><?= htmlspecialchars($task['title']) ?></h3>
                <p><?= htmlspecialchars($task['description']) ?></p>
                <small>Created: <?= $task['created_at'] ?></small>
                <?php if ($task['due_date']): ?>
                    <small class="<?= $is_overdue ? 'overdue' : 'due-date' ?>">
                        <?= $is_overdue ? '⚠ Overdue: ' : '📅 Due: ' ?>
                        <?= $due->format('M j, Y') ?>
                    </small>
                <?php endif; ?>
                <span class="priority-badge priority-<?= $task['priority'] ?>">
                    <?= ucfirst($task['priority']) ?> Priority
                </span>
            </div>
            <div class="task-actions">
                <?php if ($task['status'] == 'pending'): ?>
                    <a href="complete_task.php?id=<?= $task['id'] ?>" class="btn complete">✔ Complete</a>
                    <a href="edit_task.php?id=<?= $task['id'] ?>" class="btn edit">✏ Edit</a>
                <?php else: ?>
                    <span class="badge">✔ Done</span>
                <?php endif; ?>
                <a href="delete_task.php?id=<?= $task['id'] ?>" class="btn delete" onclick="return confirm('Delete this task?')">🗑 Delete</a>
            </div>
        </div>
    </div>
<?php endwhile; ?>
             
        <?php endif; ?>
    </div>
</div>

</body>
</html>