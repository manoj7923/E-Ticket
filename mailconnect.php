<?php
session_start();
require_once "db_conn.php";

$nname      = isset($_POST['name']) ? trim($_POST['name']) : '';
$eemail     = isset($_POST['Email']) ? trim($_POST['Email']) : '';
$nmobile    = isset($_POST['mobile']) ? trim($_POST['mobile']) : '';
$tcomplaint = isset($_POST['complaint']) ? trim($_POST['complaint']) : '';
$category   = isset($_POST['category']) ? trim($_POST['category']) : 'General';

if (empty($nname) || empty($tcomplaint)) {
    header("Location: Contect.php?error=Name and Complaint description are required");
    exit();
}

$safe_name  = addslashes($nname);
$safe_email = addslashes($eemail);
$safe_phone = addslashes($nmobile);
$safe_text  = addslashes($tcomplaint);
$safe_cat   = addslashes($category);

$sql = "INSERT INTO complaint (cname, cemail, cmobile, ccomplaint, category, status)
        VALUES ('$safe_name', '$safe_email', '$safe_phone', '$safe_text', '$safe_cat', 'In Progress')";

if ($conn->query($sql)) {
    header("Location: Contect.php?sent=success");
    exit();
} else {
    // Fallback if table had original columns
    $fallback_sql = "INSERT INTO complaint (cname, cemail, cmobile, ccomplaint)
                    VALUES ('$safe_name', '$safe_email', '$safe_phone', '$safe_text')";
    if ($conn->query($fallback_sql)) {
        header("Location: Contect.php?sent=success");
        exit();
    } else {
        echo "Error saving complaint: " . $conn->error;
    }
}
?>
