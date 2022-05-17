<?php

$bnum = filter_input(INPUT_POST, 'trn');
$bdasti = filter_input(INPUT_POST, 'dst');
$bmode = filter_input(INPUT_POST, 'mode');
$bprice = filter_input(INPUT_POST, 'pric');
$buname = filter_input(INPUT_POST, 'uname1');
$pay = filter_input(INPUT_POST, 'pay2');


if (!empty($bnum)){
if (!empty($bdasti)){
if (!empty($bmode)){
if (!empty($bprice)){
if (!empty($buname)){	
if (!empty($pay)){	
	
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
$sql = "INSERT INTO booking (tnom,tdastinaton,tstatus,tvalue,username,trnNo)
values ('$bnum','$bdasti','$bmode','$bprice','$buname','$pay')";
if ($conn->query($sql)){
header( "Location: payment.php");
}
else{
echo "Error: ". $sql ."
". $conn->error;
}
$conn->close();
}
}
else{
echo "";
die();
}
}
else{
echo "To should not be empty";
die();
}
}
else{
echo "From should not be empty";
die();
}
}
else{
echo "From time not be empty";
die();
}
}
else{
echo " time not be empty";
die();
}
}
else{
echo " time not be empty";
die();
}


?>