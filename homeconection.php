<?php
$nfrom = filter_input(INPUT_POST, 'data');
$eto = filter_input(INPUT_POST, 'data1');
$ndate = filter_input(INPUT_POST, 'Date');
$tsatus = filter_input(INPUT_POST, 'single');
$tusname = filter_input(INPUT_POST, 'uname1');
if (!empty($nfrom)){
if (!empty($eto)){
if (!empty($ndate)){
if (!empty($tsatus)){
if (!empty($tusname)){	

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
$sql = "INSERT INTO ordertick (ffrom,fto,fdate,fstatus,username )
values ('$nfrom','$eto','$ndate','$tsatus','$tusname')";
if ($conn->query($sql)){
header( "Location: Teckit.php");
}
else{
echo "Error: ". $sql ."
". $conn->error;
}
$conn->close();
}


}
else{
echo "Date No should not be empty";
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
?>