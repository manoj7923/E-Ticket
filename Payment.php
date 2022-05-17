<?php 
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
 
 ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="icon" href="image/icon1.png" type="img/x-icon">
  <title>Payment Gateway </title>
  <link rel="stylesheet" type="text/css" href="css/payment.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	
    <script>
        setTimeout(function(){
            $('.loader_bg').fadeToggle();
        }, 2500);
    </script> 

</head>
<body>

<div class="loader_bg">
    <div class="loader"></div>
</div> 

<center>
<h1>Your Payment Gateway</h1>

<br>
<div class="container">
<?php
                                                            include 'Conn.php';
                                                                $sql="SELECT o1.tnom,b1.fdate,b1.fstatus,o1.tdastinaton,o1.tstatus,o1.tvalue,d1.ticketNo FROM booking o1, ordertick b1, trains d1 order by o1.id desc LIMIT 1";
                                                                $result=$conn->query($sql);
                                                            
                                                                $no=0;
                                                                    while($row = $result->fetch_assoc())
                                                                    {
                                                                        $no++;


                                                            ?>
  <form  action="pamentconn.php" method="post" >
  
 <font color="blue" > Enter Any Number to Confirm Your Payment</font>
 
    <input type="number" id="CaptchaEnter" name="text1" placeholder="Enter Number  " required /><br>
	<input type="hidden"  name="uname" value="<?php echo $_SESSION['name']; ?>"/>
	 <input type="hidden" name="pay1"  value="<?=$row['tvalue']?>" />
	

    <input type="submit"  id="checkbtn" />
  
  </form>
    <?php          
                                                                    }
                                                            
                                                            ?>	

</div>
</center>



   
</body>
</html>
<?php 
}else{
     header("Location: Payment.php");
     exit();
}
 ?>