<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $priority = mysqli_real_escape_string($conn, $_POST['priority']);
    $due_date = mysqli_real_escape_string($conn, $_POST['due_date']);
    $user_id = $_SESSION['user_id'];

    if (!empty($title)) {
        $query = "INSERT INTO tasks (title, description, priority, due_date, user_id) VALUES ('$title', '$description', '$priority', '$due_date', '$user_id')";
        mysqli_query($conn, $query);
    }
}

header('Location: dashboard.php');
exit();
?>