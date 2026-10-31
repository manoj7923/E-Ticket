
Captcha:
<?php
$nol=rand(1, 100);
$no2=rand(1,100);
echo $nol."+".$no2;
?>

<form method="post">
<input type="hidden" name="no1" value="<?php echo $nol ?>">
<input type="hidden" name="no2" value="<?php echo $no2 ?>">
<Input type="text" name="userans">
<input type="submit"value="submit" name="submit">
</form>



<?php
if(isset($_REQUEST["submit"]))
{
   $userans=$_REQUEST ["userans"];
   $number1=$_REQUEST ["no1"];
   $number2=$_REQUEST ["no2"];
   $total=$number1+$number2; 	
   if($total==$userans)
    {
       echo "Your Payment successfully";
    }
  else
    {
       echo"Your Payment failed";
    }
}
?>
