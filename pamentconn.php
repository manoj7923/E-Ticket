<?php
session_start();
require_once "db_conn.php";

$ptext = isset($_POST['text1']) ? trim($_POST['text1']) : ('TXN' . rand(100000, 999999));
$ppay  = isset($_POST['pay1']) ? (float)$_POST['pay1'] : 15.00;
$puser = isset($_POST['uname']) ? trim($_POST['uname']) : ($_SESSION['name'] ?? 'Passenger');
$pmethod = isset($_POST['payment_method']) ? trim($_POST['payment_method']) : 'UPI / Online';

$safe_text = addslashes($ptext);
$safe_pay  = $ppay;
$safe_user = addslashes($puser);
$safe_method = addslashes($pmethod);
$safe_txn = 'TXN_WR_' . rand(10000000, 99999999);

$_SESSION['last_txn_id'] = $safe_txn;
$_SESSION['payment_confirmed'] = true;

$sql = "INSERT INTO payment (ppayment, pptext, username, payment_method, transaction_id, payment_status)
        VALUES ('$safe_pay', '$safe_text', '$safe_user', '$safe_method', '$safe_txn', 'SUCCESS')";

if ($conn->query($sql)) {
    header("Location: trainteckit.php?status=success");
    exit();
} else {
    // Fallback if table had original columns
    $fallback_sql = "INSERT INTO payment (ppayment, pptext, username)
                    VALUES ('$safe_pay', '$safe_text', '$safe_user')";
    if ($conn->query($fallback_sql)) {
        header("Location: trainteckit.php?status=success");
        exit();
    } else {
        echo "Error recording payment: " . $conn->error;
    }
}
?>
