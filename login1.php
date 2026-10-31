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
        header("Location: index1.php?error=Admin Username is required");
        exit();
    } else if (empty($pass)) {
        header("Location: index1.php?error=Admin Password is required");
        exit();
    } else {
        $pass_hash = md5($pass);
        $safe_uname = addslashes($uname);

        $sql = "SELECT * FROM admin WHERE user_name='$safe_uname' AND (password='$pass_hash' OR password='$pass')";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['user_name'] = $row['user_name'];
            $_SESSION['name'] = !empty($row['name']) ? $row['name'] : 'Administrator';
            $_SESSION['id'] = $row['id'];
            $_SESSION['is_admin'] = true;
            $_SESSION['role'] = $row['role'] ?? 'Admin';
            header("Location: adminindex.php");
            exit();
        } else {
            header("Location: index1.php?error=Incorrect Admin credentials. (Demo: admin / admin123)");
            exit();
        }
    }
} else {
    header("Location: index1.php");
    exit();
}
?>
