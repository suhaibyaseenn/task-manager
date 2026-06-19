<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $user_id = $_SESSION['user_id'];

    if (!empty($title)) {
        $query = "INSERT INTO tasks (title, description, user_id) VALUES ('$title', '$description', '$user_id')";
        mysqli_query($conn, $query);
    }
}

header('Location: /index.php');
exit();
?>