<?php
session_start();
require_once "db_conn.php";

$bnum   = isset($_POST['trn']) ? trim($_POST['trn']) : '';
$bdasti = isset($_POST['dst']) ? trim($_POST['dst']) : '';
$bmode  = isset($_POST['mode']) ? trim($_POST['mode']) : '';
$bprice = isset($_POST['pric']) ? (float)$_POST['pric'] : 0.0;
$buname = isset($_POST['uname1']) ? trim($_POST['uname1']) : ($_SESSION['name'] ?? 'Passenger');
$buname2 = isset($_POST['uname2']) ? trim($_POST['uname2']) : 'Cancelled';
$bnum1  = isset($_POST['trn1']) ? trim($_POST['trn1']) : '';

if (empty($bnum) || empty($bdasti) || empty($buname)) {
    header("Location: Cencel Teckit.php");
    exit();
}

$safe_num   = addslashes($bnum);
$safe_dasti = addslashes($bdasti);
$safe_mode  = addslashes($bmode);
$safe_price = $bprice;
$safe_uname = addslashes($buname);
$safe_stat  = addslashes($buname2);
$safe_token = addslashes($bnum1);

$clerkage_fee = min(5.00, $safe_price);
$refund_amt   = max(0.00, $safe_price - $clerkage_fee);

$sql = "INSERT INTO cancelbooking (cnom, cdastinaton, cstatus, cvalue, username, bokingstatus, TrNo, refund_amount, refund_status)
        VALUES ('$safe_num', '$safe_dasti', '$safe_mode', '$safe_price', '$safe_uname', '$safe_stat', '$safe_token', '$refund_amt', 'Processed')";

if ($conn->query($sql)) {
    // Optionally remove from active bookings so it doesn't show again
    $del_sql = "DELETE FROM booking WHERE trnNo='$safe_token' OR (tnom='$safe_num' AND username='$safe_uname') LIMIT 1";
    @$conn->query($del_sql);

    header("Location: Cencel Teckit.php?cancelled=success");
    exit();
} else {
    // Fallback if table had old columns
    $fallback_sql = "INSERT INTO cancelbooking (cnom, cdastinaton, cstatus, cvalue, username, bokingstatus, TrNo)
                    VALUES ('$safe_num', '$safe_dasti', '$safe_mode', '$safe_price', '$safe_uname', '$safe_stat', '$safe_token')";
    if ($conn->query($fallback_sql)) {
        header("Location: Cencel Teckit.php?cancelled=success");
        exit();
    } else {
        echo "Error recording cancellation: " . $conn->error;
    }
}
?>
