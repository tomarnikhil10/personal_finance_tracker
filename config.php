<?php
$host = 'dpg-cvppr615pdvs73edep50-a.oregon-postgres.render.com';
$db   = 'personal_finance_db_1wd9';
$user = 'personal_finance_db_1wd9_user';
$pass = 'qtULMnZrMU4qUYtt5axR6z91oxTv0uWM';
$port = '5432';

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected to PostgreSQL successfully!";
} catch (PDOException $e) {
    die("PostgreSQL connection failed: " . $e->getMessage());
}
?>
