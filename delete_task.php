<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
}

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $user_id = $_SESSION['user_id'];
    mysqli_query($conn, "DELETE FROM tasks WHERE id=$id AND user_id=$user_id");
}

header('Location: dashboard.php');
exit();
?>