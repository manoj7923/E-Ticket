<?php
$nname = filter_input(INPUT_POST, 'name');
$eemail = filter_input(INPUT_POST, 'Email');
$nmobile = filter_input(INPUT_POST, 'mobile');
$tcomplaint = filter_input(INPUT_POST, 'complaint');
if (!empty($nname)){
if (!empty($eemail)){
if (!empty($nmobile)){
if (!empty($tcomplaint)){

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
$sql = "INSERT INTO complaint (cname,cemail,cmobile,ccomplaint )
values ('$nname','$eemail','$nmobile','$tcomplaint')";
if ($conn->query($sql)){
header( "Location:contect.php");
}
else{
echo "Error: ". $sql ."
". $conn->error;
}
$conn->close();
}


}
else{
echo "Mobile No should not be empty";
die();
}
}
else{
echo "Email should not be empty";
die();
}
}
else{
echo "Name should not be empty";
die();
}
}


?>