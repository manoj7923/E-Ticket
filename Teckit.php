<?php 
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {

 ?>
<!DOCTYPE HTML>
<html lang="en">
<head>
      <meta charset="UTF-8">
	  <link rel="icon" href="image/icon1.png" type="img/x-icon">
  <title> E- Ticket System For Local Train </title>
  <link rel="stylesheet" type="text/css" href="css/Teckit.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script>
	
function goBack() {
  window.history.back();
}
	</script>
    <script>
        setTimeout(function(){
            $('.loader_bg').fadeToggle();
        }, 1500);
    </script>
	    <script type="text/javascript">
        var IdealTimeOut = 120; //120 seconds
        var idleSecondsTimer = null;
        var idleSecondsCounter = 0;
        document.onclick = function () { idleSecondsCounter = 0; };
        document.onmousemove = function () { idleSecondsCounter = 0; };
        document.onkeypress = function () { idleSecondsCounter = 0; };
        idleSecondsTimer = window.setInterval(CheckIdleTime, 1000);
 
        function CheckIdleTime() {
            idleSecondsCounter++;
            var oPanel = document.getElementById("timeOut");
            if (oPanel) {
                oPanel.innerHTML = (IdealTimeOut - idleSecondsCounter);
            }
            if (idleSecondsCounter >= IdealTimeOut) {
                window.clearInterval(idleSecondsTimer);
                alert("Your Session has expired. Please login again.");
                window.location = "Logout.php";
            }
        }
    </script>
	
</head>	

<body>
 
<div class="loader_bg">
    <div class="loader"></div>
</div>


       <header> 
	   

	   <div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
<div class="baner2">
<a href="Home.php" class="animated">Hello <?php echo $_SESSION['name']; ?></a>
</div>    
  <div class="name">
  <a> <img src="image/icon9.jpg">
</div> </a> 
 <div class="logout">
 <a> &nbsp;&nbsp;
 </div></a>
 <a href="Home.php">Home</a>
<a href="Cencel Teckit.php">Cancle Ticket</a>
  <a href="About.php">About</a>
<a href="Contect.php">Contact</a>
</div>

<div class="manu">
<span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; </span>

</div>
   
	   <h1 class="usericon"><img src="image/icon9.jpg"></h1>
	   <h2 class="usern"><b>User : &nbsp; <?php echo $_SESSION['name']; ?><br><a href="logout.php">Logout</a></h2>
	   <div class="topicon">
	             <a href="Home.php"> <img src="image/icon3.png">  </a> 
			  </div>

			   <div class="banor">
				   </big><marquee><h1><font color="red" >Welcome To E-Ticket System&nbsp;!!&nbsp; <?php echo $_SESSION['name']; ?> </font></h1></marquee><br></big> </div>
				  <br><br><div class="Timeout">
			    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You will be auto logged out in <font color="blue">(<span style="font-size:19px" id="timeOut"></span>)</font> seconds.
			  </div>
				 

</header>

    <?php
            include 'db_conn.php';
		                                                 
            $sql="SELECT t1.numbertrain,t1.returnTno,t1.ticketNo,o1.ffrom, o1.fto,s1.ssingle,s1.RReturn FROM ordertick o1,sstatus s1, trains t1 order by o1.id desc LIMIT 1;"; 
			
             
            $result=$conn->query($sql);
            $no=0;
	
			
                while($row = $result->fetch_assoc())
                {
                    $no++;
				

        ?>	        
<table name="table">	
        <tr id="header" >
            <th>Sr.No</th>
            <th>Train NO</th>
            <th>Dastination</th>
            <th>Status</th>
            <th>Amount</th>
            <th>Booking Teckit</th>
        </tr>
</table>		                                                     
	
<form action="Teckitconne.php"  method="post">
<div class="srno" >
1
</div>
<div class="trno" >
<input type="text" name="trn"  value="<?=$row['numbertrain']?>"/></input>
</div>
<div class="dasti" >
<input type="text" name="dst"  value="<?=$row['ffrom'];?> To <?=$row['fto'];?>"> </input>
</div>

<div class="mode" >
<input type="text" name="mode"  value="Single"/></input>
</div>

<div class="pric">
<input type="text" name="pric"  value="<?=$row['ssingle'];?>"/>
<input type="hidden"  name="uname1" value="<?php echo $_SESSION['name']; ?>">
 <input type="hidden" name="pay2"  value="<?=$row['ticketNo']?>" />

</div>

<button type="submit" class="button"  value="submit" ><b>Book Now</button></b>

</form> 


<form  class="form1" action="Teckitconne.php" method="post">
<div class="srno">
2
</div>
<div class="trno" >
<input type="text" name="trn"  value="<?=$row['returnTno']?>"/></input>
</div>
<div class="dasti" >
<input type="text" name="dst"  value="<?=$row['ffrom'];?> To <?=$row['fto'];?>"> </input>
</div>
<div class="mode" >
<input type="text" name="mode"  value="Return"/></input>
</div>
<div class="pric">
<input type="text" name="pric"  value="<?=$row['RReturn'];?>"/>
<input type="hidden"  name="uname1" value="<?php echo $_SESSION['name']; ?>">
<input type="hidden" name="pay2"  value="<?=$row['ticketNo']?>" />
</div>

<button type="submit"  class="button" value="submit"><b>Book Now</button></b>
</form> 
   
   <?php
				}
	?>
	
   
      
	
      



 
                            

 				 

                            

					  <script src="java/Teckit.js"></script>
						
			<footer>
		
        <div class="f1">&copy;2021 | E- Ticket System For Local Train</div>
        <div class="f2">All Rights Reserved</div>
    </footer>

</body>
</html>
<?php 
}else{
     header("Location: Teckit.php");
     exit();
}
 ?>