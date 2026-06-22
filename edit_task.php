<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch the task to pre-fill the form
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM tasks WHERE id=$id AND user_id='$user_id'");
    $task = mysqli_fetch_assoc($result);

    if (!$task) {
        header('Location: dashboard.php');
        exit();
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     $id = (int) $_POST['id'];
     $title = mysqli_real_escape_string($conn, $_POST['title']);
     $description = mysqli_real_escape_string($conn, $_POST['description']);
     $priority = mysqli_real_escape_string($conn, $_POST['priority']);
     $due_date = !empty($_POST['due_date']) ? mysqli_real_escape_string($conn, $_POST['due_date']) : NULL;
     $due_date_value = $due_date ? "'$due_date'" : "NULL";
    
    
     if (!empty($title)) {
        mysqli_query($conn, "UPDATE tasks SET title='$title', description='$description', priority='$priority', due_date=$due_date_value WHERE id=$id AND user_id='$user_id'");
    }

    header('Location: dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task | Task Manager</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
    <div class="nav-brand">Task Manager</div>
    <div class="nav-right">
        <span class="nav-user">👋 Welcome, <?= htmlspecialchars($_SESSION['username']) ?></span>
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>
</nav>

<div class="container">
    <div class="form-box">
        <h2>Edit Task</h2>
        <form action="edit_task.php" method="POST">
            <input type="hidden" name="id" value="<?= $task['id'] ?>">
            <input type="text" name="title" value="<?= htmlspecialchars($task['title']) ?>" required>
            <input type="date" name="due_date" value="<?= $task['due_date'] ?? '' ?>">
            <textarea name="description"><?= htmlspecialchars($task['description']) ?></textarea>
            <select name="priority">
                <option value="low" <?= $task['priority'] == 'low' ? 'selected' : '' ?>>🟢 Low</option>
                <option value="medium" <?= $task['priority'] == 'medium' ? 'selected' : '' ?>>🟡 Medium</option>
                <option value="high" <?= $task['priority'] == 'high' ? 'selected' : '' ?>>🔴 High</option>
            </select>
            <button type="submit">Save Changes</button>
            <a href="dashboard.php" style="display:block; text-align:center; margin-top:12px; color:#777;">Cancel</a>
        </form>
    </div>
</div>

</body>
</html>