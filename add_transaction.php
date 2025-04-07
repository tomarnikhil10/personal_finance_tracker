<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $amount = $_POST['amount'];
    $category = $_POST['category'];
    $type = $_POST['type'];
    $date = $_POST['date'];

    $query = "INSERT INTO transactions (user_id, amount, category, type, date) VALUES ('$user_id', '$amount', '$category', '$type', '$date')";
    if (mysqli_query($conn, $query)) {
        header('Location: dashboard.php');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Transaction</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <h2>Add Transaction</h2>
    <form method="post" action="add_transaction.php">
        <label for="amount">Amount:</label>
        <input type="text" id="amount" name="amount" required>
        <label for="category">Category:</label>
        <input type="text" id="category" name="category" required>
        <label for="type">Type:</label>
        <select id="type" name="type">
            <option value="income">Income</option>
            <option value="expense">Expense</option>
        </select>
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>
        <button type="submit">Add</button>
    </form>
</body>
</html>
