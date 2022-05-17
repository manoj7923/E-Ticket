<?php
$ptext = filter_input(INPUT_POST, 'text1');
$ppay = filter_input(INPUT_POST, 'pay1');
$puser = filter_input(INPUT_POST, 'uname');



if (!empty($ptext)){
if (!empty($ppay)){	
if (!empty($puser)){	

$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "test";

// Create connection
$conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);


if (mysqli_connect_error()){
die('Connect Error ('. mysqli_connect_errno() .') '
. mysqli_connect_error());
}
else{
$sql = "INSERT INTO payment (ppayment,pptext,username )
values ('$ppay','$ptext','$puser')";
if ($conn->query($sql)){
header( "Location: trainteckit.php");
}
else{
echo "Error: ". $sql ."
". $conn->error;
}
$conn->close();
}



}
}
}

?>