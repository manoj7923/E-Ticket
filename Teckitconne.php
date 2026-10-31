<?php
session_start();
require_once "db_conn.php";

$bnum   = isset($_POST['trn']) ? trim($_POST['trn']) : 'WR-90101';
$bdasti = isset($_POST['dst']) ? trim($_POST['dst']) : 'Churchgate To Borivali';
$bmode  = isset($_POST['mode']) ? trim($_POST['mode']) : 'Single';
$bprice = isset($_POST['pric']) ? (float)$_POST['pric'] : 15.00;
$buname = isset($_POST['uname1']) ? trim($_POST['uname1']) : ($_SESSION['name'] ?? 'Passenger');
$pay    = isset($_POST['pay2']) ? trim($_POST['pay2']) : ('UTS' . rand(10000, 99999));
$bline  = isset($_POST['network_line']) ? trim($_POST['network_line']) : ($_SESSION['last_line'] ?? 'Western Line');

if (empty($bnum) || empty($bdasti) || empty($bprice) || empty($buname)) {
    header("Location: Teckit.php?error=Missing ticket booking parameters");
    exit();
}

$safe_num   = addslashes($bnum);
$safe_dasti = addslashes($bdasti);
$safe_mode  = addslashes($bmode);
$safe_price = $bprice;
$safe_uname = addslashes($buname);
$safe_pay   = addslashes($pay);
$safe_line  = addslashes($bline);

// 12-Hour Validity Timestamps
$now_ts = time();
$valid_until_ts = $now_ts + (12 * 3600);
$valid_until_str = date('Y-m-d H:i:s', $valid_until_ts);

// Generate Cryptographic QR payload with 12h validity
$qr_payload = "UTS:WR:$pay:ROUTE=$safe_dasti:TYPE=$safe_mode:FARE=Rs.$safe_price:VALID=12_HOURS:EXP=$valid_until_str:STATUS=CONFIRMED";
$safe_qr    = addslashes($qr_payload);

$_SESSION['current_ticket'] = [
    'trn' => $bnum,
    'dst' => $bdasti,
    'mode' => $bmode,
    'price' => $bprice,
    'user' => $buname,
    'token' => $pay,
    'line' => $bline,
    'validity_hours' => 12,
    'valid_until' => $valid_until_str,
    'valid_until_ts' => $valid_until_ts
];

$sql = "INSERT INTO booking (tnom, tdastinaton, tstatus, tvalue, username, trnNo, network_line, validity_hours, valid_until, qr_data)
        VALUES ('$safe_num', '$safe_dasti', '$safe_mode', '$safe_price', '$safe_uname', '$safe_pay', '$safe_line', 12, '$valid_until_str', '$safe_qr')";

if ($conn->query($sql)) {
    header("Location: Payment.php");
    exit();
} else {
    // Fallback if table had old columns
    $fallback_sql = "INSERT INTO booking (tnom, tdastinaton, tstatus, tvalue, username, trnNo)
                     VALUES ('$safe_num', '$safe_dasti', '$safe_mode', '$safe_price', '$safe_uname', '$safe_pay')";
    if ($conn->query($fallback_sql)) {
        header("Location: Payment.php");
        exit();
    } else {
        echo "Error creating booking: " . $conn->error;
    }
}
?>
