<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'config.php';

$user_id = $_SESSION['user_id'];

// Fetch total income, total expenses, and current balance
$query = "SELECT 
            SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) AS total_income,
            SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) AS total_expense 
          FROM transactions 
          WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);
$summary = mysqli_fetch_assoc($result);
$total_income = $summary['total_income'] ?? 0;
$total_expense = $summary['total_expense'] ?? 0;
$current_balance = $total_income - $total_expense;

// Fetch recent transactions
$query = "SELECT id, amount, category, type, date FROM transactions WHERE user_id = '$user_id' ORDER BY date DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <div class="header">
        <h2>Personal Finance Tracker</h2>
    </div>
    <div class="container">
        <div class="summary">
            <p>Total Income: $<?php echo number_format($total_income, 2); ?></p>
            <p>Total Expense: $<?php echo number_format($total_expense, 2); ?></p>
            <p>Current Balance: $<?php echo number_format($current_balance, 2); ?></p>
        </div>
        <a href="add_transaction.php" class="button">Add Transaction</a>
        <a href="logout.php" class="button">Logout</a>
        <h3>Recent Transactions</h3>
        <table>
            <tr>
                <th>Amount</th>
                <th>Category</th>
                <th>Type</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
            <?php while ($transaction = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $transaction['amount']; ?></td>
                <td><?php echo $transaction['category']; ?></td>
                <td><?php echo ucfirst($transaction['type']); ?></td>
                <td><?php echo $transaction['date']; ?></td>
                <td class="actions">
                    <a href="edit_transaction.php?id=<?php echo $transaction['id']; ?>">Edit</a>
                    <a href="delete_transaction.php?id=<?php echo $transaction['id']; ?>" onclick="return confirm('Are you sure you want to delete this transaction?');">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
