<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$transaction_id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $amount = $_POST['amount'];
    $category = $_POST['category'];
    $type = $_POST['type'];
    $date = $_POST['date'];

    $query = "UPDATE transactions SET amount='$amount', category='$category', type='$type', date='$date' WHERE id='$transaction_id'";
    if (mysqli_query($conn, $query)) {
        header('Location: dashboard.php');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
} else {
    $query = "SELECT * FROM transactions WHERE id='$transaction_id' AND user_id='" . $_SESSION['user_id'] . "'";
    $result = mysqli_query($conn, $query);
    $transaction = mysqli_fetch_assoc($result);
    if (!$transaction) {
        echo "Transaction not found.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Transaction</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <h2>Edit Transaction</h2>
    <form method="post" action="edit_transaction.php?id=<?php echo $transaction_id; ?>">
        <label for="amount">Amount:</label>
        <input type="text" id="amount" name="amount" value="<?php echo $transaction['amount']; ?>" required>
        <label for="category">Category:</label>
        <input type="text" id="category" name="category" value="<?php echo $transaction['category']; ?>" required>
        <label for="type">Type:</label>
        <select id="type" name="type">
            <option value="income" <?php if ($transaction['type'] == 'income') echo 'selected'; ?>>Income</option>
            <option value="expense" <?php if ($transaction['type'] == 'expense') echo 'selected'; ?>>Expense</option>
        </select>
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" value="<?php echo $transaction['date']; ?>" required>
        <button type="submit">Update</button>
    </form>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
