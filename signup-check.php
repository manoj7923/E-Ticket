<?php 
session_start(); 
require_once "db_conn.php";

if (isset($_POST['uname']) && isset($_POST['password'])
    && isset($_POST['name']) && isset($_POST['re_password'])) {

    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }

    $uname = validate($_POST['uname']);
    $pass = validate($_POST['password']);
    $re_pass = validate($_POST['re_password']);
    $name = validate($_POST['name']);
    $email = isset($_POST['email']) ? validate($_POST['email']) : '';
    $mobile = isset($_POST['mobile']) ? validate($_POST['mobile']) : '';

    $user_data = 'uname='. urlencode($uname) . '&name='. urlencode($name) . '&email=' . urlencode($email);

    if (empty($uname)) {
        header("Location: signup.php?error=Username is required&$user_data");
        exit();
    } else if (empty($pass)) {
        header("Location: signup.php?error=Password is required&$user_data");
        exit();
    } else if (empty($re_pass)) {
        header("Location: signup.php?error=Please confirm your password&$user_data");
        exit();
    } else if (empty($name)) {
        header("Location: signup.php?error=Full Name is required&$user_data");
        exit();
    } else if ($pass !== $re_pass) {
        header("Location: signup.php?error=The confirmation passwords do not match&$user_data");
        exit();
    } else {
        $pass_hash = md5($pass);
        $safe_uname = addslashes($uname);
        $safe_name = addslashes($name);
        $safe_email = addslashes($email);
        $safe_mobile = addslashes($mobile);

        // Check if username already exists
        $check_sql = "SELECT id FROM users WHERE user_name='$safe_uname'";
        $result = $conn->query($check_sql);

        if ($result && $result->num_rows > 0) {
            header("Location: signup.php?error=Username is already taken, please choose another&$user_data");
            exit();
        } else {
            $insert_sql = "INSERT INTO users (user_name, password, name, email, mobile) VALUES ('$safe_uname', '$pass_hash', '$safe_name', '$safe_email', '$safe_mobile')";
            if ($conn->query($insert_sql)) {
                header("Location: index.php?success=Account created successfully! Please login with your credentials.");
                exit();
            } else {
                header("Location: signup.php?error=Database error: unable to register. Please try again.&$user_data");
                exit();
            }
        }
    }
} else {
    header("Location: signup.php");
    exit();
}
?>
