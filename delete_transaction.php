<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$transaction_id = $_GET['id'];

$query = "DELETE FROM transactions WHERE id='$transaction_id' AND user_id='" . $_SESSION['user_id'] . "'";
if (mysqli_query($conn, $query)) {
    header('Location: dashboard.php');
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
}
?>
