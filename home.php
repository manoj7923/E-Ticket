<?php 
session_start();
date_default_timezone_set("Asia/Calcutta");
if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {

 ?>
<!DOCTYPE html>
<html>
<head>

	<title>HOME</title>
	  <link rel="icon" href="image/icon1.png" type="img/x-icon">
	<link rel="stylesheet" type="text/css" href="css/Home.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
	   function preback(){window.history.forward()};
	   setTimeout("preback()",0);
	   window.onunload=function()(null;)
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
<div class="box-area">

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
				   <marquee><h1><font color="red" >Welcome To Western Line Natwork  </font></h1></marquee><br> </div>
				  
				  <br><br><br><br><div class="Timeout">
			             You will be auto logged out in <font color="blue">(<span style="font-size:19px" id="timeOut"></span>)</font> seconds.
			  </div>
	  </header>     
	  
	
				  <center><form action="homeconection.php" method="post">
				    <div class="imgcontainer">
                   <img src="image/icon4.jpg"> 
				   </div>
				    <div>
					
		          <b>  <div class= "from1">From: <br></div><br>
		        
				       <div class= "Station1"><br>
					   <input list="data" placeholder=" Select Your Station" type="search" id="stan1" name="data"  required>

                 <datalist id="data">
				<option value="Churchgate">Churchgate</OPTION>
				<option value="Marine Lines">Marine Lines</OPTION>
				<option value="Charni Road">Charni Road</OPTION>
				<option value="Grant Road">Grant Road</OPTION>
				<option value="Mumbai Central">Mumbai Central</OPTION>
				<option value="Mahalaxmi">Mahalaxmi</OPTION> 
				<option value="Lower Parel">Lower Parel</OPTION>
				<option value="Elphinstone Road">Elphinstone Road</OPTION>
				<option value="Dadar">Dadar</OPTION>
				<option value="Matunga Road">Matunga Road </OPTION>
				<option value="Mahim">Mahim</OPTION>
				<option value="Bandra">Bandra</OPTION>
				<option value="Khar Road">Khar Road</OPTION> 	
              	<option value="Santacruz">Santacruz</OPTION>
				<option value="Vile Parle">Vile Parle</OPTION>
				<option value="Andheri">Andheri</OPTION>
				<option value="Jogeshwari">Jogeshwari</OPTION>
				<option value="Goregaon">Goregaon</OPTION>
				<option value="Malad">Malad</OPTION>
				<option value="Kandivali">Kandivali</OPTION>
				<option value="Borivali">Borivali</OPTION> 
				<option value="Dahisar">Dahisar</OPTION>
				<option value="Mira Road">Mira Road</OPTION>
				<option value="Bhayandar">Bhayandar</OPTION>
				<option value="Naigaon">Naigaon	</OPTION>
				<option value="Vasai Road">Vasai Road</OPTION>
				<option value="Nala Sopara">Nala Sopara</OPTION>
				<option value="Virar">Virar</OPTION> 	
				<option value="valtarna">valtarna</OPTION>
				<option value="Saphale">Saphale</OPTION>
				<option value="Kelve Road">Kelve Road</OPTION>
				<option value="Palghar">Palghar</OPTION>
				<option value="Umroli">Umroli</OPTION>
				<option value="Boisar">Boisar</OPTION>
				<option value="Vangaon">Vangaon</OPTION>
				<option value="Dahanu Road">Dahanu Road</OPTION>  							
               </datalist></input></div>

				  <div class= "to">To:</div><br>
				  
			         <div class= "Station2"> <b>
					<input list="data1" placeholder=" Select Your Station" type="search" id="To" name="data1" required > 

                 <datalist id="data1">
					<option value="Churchgate">Churchgate</OPTION>
				<option value="Marine Lines">Marine Lines</OPTION>
				<option value="Charni Road">Charni Road</OPTION>
				<option value="Grant Road">Grant Road</OPTION>
				<option value="Mumbai Central">Mumbai Central</OPTION>
				<option value="Mahalaxmi">Mahalaxmi</OPTION> 
				<option value="Lower Parel">Lower Parel</OPTION>
				<option value="Elphinstone Road">Elphinstone Road</OPTION>
				<option value="Dadar">Dadar</OPTION>
				<option value="Matunga Road">Matunga Road </OPTION>
				<option value="Mahim">Mahim</OPTION>
				<option value="Bandra">Bandra</OPTION>
				<option value="Khar Road">Khar Road</OPTION> 	
              	<option value="Santacruz">Santacruz</OPTION>
				<option value="Vile Parle">Vile Parle</OPTION>
				<option value="Andheri">Andheri</OPTION>
				<option value="Jogeshwari">Jogeshwari</OPTION>
				<option value="Goregaon">Goregaon</OPTION>
				<option value="Malad">Malad</OPTION>
				<option value="Kandivali">Kandivali</OPTION>
				<option value="Borivali">Borivali</OPTION> 
				<option value="Dahisar">Dahisar</OPTION>
				<option value="Mira Road">Mira Road</OPTION>
				<option value="Bhayandar">Bhayandar</OPTION>
				<option value="Naigaon">Naigaon	</OPTION>
				<option value="Vasai Road">Vasai Road</OPTION>
				<option value="Nala Sopara">Nala Sopara</OPTION>
				<option value="Virar">Virar</OPTION> 	
				<option value="valtarna">valtarna</OPTION>
				<option value="Saphale">Saphale</OPTION>
				<option value="Kelve Road">Kelve Road</OPTION>
				<option value="Palghar">Palghar</OPTION>
				<option value="Umroli">Umroli</OPTION>
				<option value="Boisar">Boisar</OPTION>
				<option value="Vangaon">Vangaon</OPTION>
				<option value="Dahanu Road">Dahanu Road</OPTION> 
				 </datalist></input></div>
			  
			              <div class="date">
							 Date:
							  </div>
							  <div class="date1">
			                     <input type="date"  name="Date" value="<?=date('Y-m-d')?>" required>
								 <input type="hidden"  name="uname1" value="<?php echo $_SESSION['name']; ?>">
							 </div>
							 
							
							 
			            
			             <div class="time"><br>
							 Time:
							 </div>
			           
                          	 <div class="time1">	

                              <input type="time"  name="single" required>

				             </div>
			     
				 <div class="reset">
				 <button type="reset"> <b>Reset</button>
				 </div>
                <div class="submit"><br>
				<button type="submit"   value="submit"   ><b>Submit</button>
                 </div>
		 	
			
</form>  
          
		   
		   
           <script  src="java/Home.js"></script> 
	    		   
	
		<footer>
		
        <div class="f1">&copy;2021 | E- Ticket System For Local Train</div>
        <div class="f2">All Rights Reserved</div>
    </footer>
	

</body>
</html>


<?php 
}else{
     header("Location: home.php");
     exit();
}
 ?>