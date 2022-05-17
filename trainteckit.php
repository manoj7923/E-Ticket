<?php 
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {

 ?>
<!DOCTYPE HTML>
<html lang="en">
<head>
      <meta charset="UTF-8">
	  <link rel="icon" href="image/icon1.png" type="img/x-icon">
  <title> E- Ticket  </title>
  <link rel="stylesheet" type="text/css" href="css/trainteckit.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	
    <script>
        setTimeout(function(){
            $('.loader_bg').fadeToggle();
        }, 1500);
    </script>
	    <script type="text/javascript">
        var IdealTimeOut = 300; //300 seconds
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
	<script>
	document.getElementById("").innerHTML=localstorage.getItem()
	 </script>
	 <style id="table_style" type="text/css">
   
</style>
<script type="text/javascript">
    function PrintTable() {
        var printWindow = window.open('', '', 'height=800,width=1000');
        printWindow.document.write('<html><head><title></title>');
 
        //Print the Table CSS.
        var table_style = document.getElementById("table_style").innerHTML;
        printWindow.document.write('<style type = "text/css">');
        printWindow.document.write(table_style);
        printWindow.document.write('</style>');
        printWindow.document.write('</head>');
 
        //Print the DIV contents i.e. the HTML Table.
        printWindow.document.write('<body>');
        var divContents = document.getElementById("dvContents").innerHTML;
        printWindow.document.write(divContents);
        printWindow.document.write('</body>');
 
        printWindow.document.write('</html>');
        printWindow.document.close();
        printWindow.print();
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
<a href="home.php" class="animated">Hello <?php echo $_SESSION['name']; ?></a>
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


<form  id="dvContents" style="border: 1px dotted black; padding: 5px; width:505px" action="Teckitconne.php" method="post">
    <table cellspacing="2" rules="all" border="1" style="width:100%">
       <div class="cardWrap">
  
  <div class="ph">
   <center>  <img src="image/icon3.png"><h1>Western Relway</h1><hr>
  </div>
   
<?php
                                                            include 'Conn.php';
                                                                $sql="SELECT o1.tnom,o1.trnNo,b1.fdate,b1.fstatus,o1.tdastinaton,o1.tstatus,o1.tvalue,d1.ticketNo FROM booking o1, ordertick b1, trains d1 order by o1.id desc LIMIT 1";
                                                                $result=$conn->query($sql);
                                                            
                                                                $no=0;
                                                                    while($row = $result->fetch_assoc())
                                                                    {
                                                                        $no++;


                                                            ?>
		

   
	<tr>
	<td colspan="8"  ><center> Local Train No: <?=$row['tnom']?></td></tr>
	<tr>
    <td colspan="4" > Date : <?=$row['fdate']?> <td rowspan="1." > Time : <?=$row['fstatus']?> </td></td></tr>
	<tr>
    <td colspan="4" > Dastinaton : <?=$row['tdastinaton']?> <td rowspan="1." > Ticket No : <?=$row['trnNo']?> </td></td></tr>
	<br>
	<tr>
	<td colspan="4" > Status : <?=$row['tstatus']?> <td colspan="4" > RS : <?=$row['tvalue']?> </td></td></tr>
	<br>
		<td colspan="8"  ><center> 	This Ticket Is Valid For Today  Night  And Wish You A Happy Journey</td></tr>
	


</div> 
       
       
  <?php          
                                                                    }
                                                            
                                                            ?>      
     
    </table>
	<p ><b>
	Note: -  This Ticket Is A Soft Copy Please Print The Ticket For The Safe Purpose !!!</b>
	</p>
	<p ><b>
	Note: -  If You Cancel Your Ticket, Your Amount Refund Within a 24HR !!!</b>
	</p>
	<p ><b><center>
	         ThanKyou</b></center>
	</p>
</form>
<br/>
<input type="button" onclick="PrintTable();" value="Print"/>                 

					  <script src="java/Teckit.js"></script>
						
			<footer>
		
        <div class="f1">&copy;2021 | E- Ticket System For Local Train</div>
        <div class="f2">All Rights Reserved</div>
    </footer>

</body>
</html>
<?php 
}else{
     header("Location: trainteckit.php");
     exit();
}
 ?>
 
