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
  <link rel="stylesheet" type="text/css" href="css/Contect.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  
  
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
<a href="Cencel Teckit.php">Cencle Teckit</a>
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
				   </big><marquee><h1><font color="red" >Wellcome To E-Teckit System&nbsp;!!&nbsp; <?php echo $_SESSION['name']; ?> </font></h1></marquee><br></big> </div>
				  <br><br><br><br><div class="Timeout">
			    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You will be auto logged out in <font color="blue">(<span style="font-size:19px" id="timeOut"></span>)</font> seconds.
			  </div>
	       </header>			  

<form  action="mailconnect.php" method="post" onsubmit="popup(this)">
<h3> <center>Contact Form</h3><br>

<div class="container">
  
    <label for="fname">Name:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="text" id="fname" name="name" placeholder="Your name.." required>
     <br>
    <label for="emailid">Email ID:</label>&nbsp;&nbsp;&nbsp;
    <input type="email" id="emailid" name="Email" placeholder=" Email Id.." required>
     <br>
    <label for="lname">Mobile No:</label>
    <input type="text" id="mobile"  name="mobile" placeholder="Mobile no.." required>
     <br>

    <label for="complaint">complaint:</label> <br>
    <textarea id="subject" name="complaint" placeholder="Write something.." style="height:180px"   required></textarea>
<br>
    <input type="submit" id="button" ></input>

</div>
</form>			
						
							  
						
			
		  <script  src="java/Home.js"></script>
		   <script>
							function popup(){
								alert("You Message Sent To Admin Sucssesfully")
							}
							 </script>
						
			<footer>
			       <div class="f1">&copy;2021 | E- Ticket System For Local Train</div>
        <div class="f2">All Rights Reserved</div>
                  </footer>


</body>
</html>

<?php 
}else{
     header("Location: Contect.php");
     exit();
}
 ?>