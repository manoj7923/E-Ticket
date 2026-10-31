<?php 
session_start(); 
require_once "db_conn.php";

if (isset($_POST['uname']) && isset($_POST['password'])) {

    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }

    $uname = validate($_POST['uname']);
    $pass = validate($_POST['password']);

    if (empty($uname)) {
        header("Location: index.php?error=User Name is required");
        exit();
    } else if (empty($pass)) {
        header("Location: index.php?error=Password is required");
        exit();
    } else {
        // Hash password
        $pass_hash = md5($pass);
        $safe_uname = addslashes($uname);

        $sql = "SELECT * FROM users WHERE user_name='$safe_uname' AND (password='$pass_hash' OR password='$pass')";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['user_name'] = $row['user_name'];
            $_SESSION['name'] = !empty($row['name']) ? $row['name'] : $row['user_name'];
            $_SESSION['id'] = $row['id'];
            $_SESSION['role'] = 'passenger';
            header("Location: home.php");
            exit();
        } else {
            header("Location: index.php?error=Incorrect username or password. (Demo: manoj / 123)");
            exit();
        }
    }
} else {
    header("Location: index.php");
    exit();
}
?>
