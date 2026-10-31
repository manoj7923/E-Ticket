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
  <link rel="stylesheet" type="text/css" href="css/Conform Details.css">
	</head>
		 <script>

/* FOR SIDE MANU BAR */
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}



 </script> 
<body>
        <header> 
	   
	 
	 
	   
	   

	   <div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

    
  <div class="name">
  <a> <img src="image/icon9.jpg">&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $_SESSION['name']; ?>	&nbsp;
</div> </a> 
 <div class="logout">
 <a> &nbsp;&nbsp;wellcome 
 </div></a>
 <a href="Home.php">Home</a>
<a href="Cencel Teckit.html">Cencle Teckit</a>
  <a href="About.html">About</a>
<a href="Contect.html">Contact</a>
</div>

<div class="manu">
<span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; </span>
</div>
    
	   <h1 class="usericon"><img src="image/icon9.jpg"></h1>
	   <h2 class="usern"><b>User : &nbsp; <?php echo $_SESSION['name']; ?><br><a href="logout.php">Logout</a></h2>
	   <div class="topicon">
	             <a href="Home.php"> <img src="image/icon3.png">  </a> 
			  </div>
				  
                  
						
					<form action="" method="put"> 
					<h1> <center>Conform Details<b><hr>   </h1> 
					<br> <b> 
			          
                              <div>From : 
							  <span id="date"></span></div>
						

                               <div class="to">TO : 
						       <span id="data"></span></div>
							 
                           <div class="date">Date : 
						    <input type="date"  name="Date1">
							</div>
						
                            <br>
                           <div class="time">Time :
						    <input type="Time"  name="time">
							</div>
							
							<div class="sr"><br>
							 NO.<br>	Ad/Ch:
			                   
				             <select name="Ad">
                             <option value="0"> 0 </OPTION> 
							 <option value="1"> 1 </OPTION>
				             <option value="2"> 2 </OPTION> 
							 <option value="3"> 3 </OPTION>
				             <option value="4"> 4 </OPTION>
							 <option value="5"> 5 </OPTION>
				             </select></div>
							 <div class="sr1"><br>
							    //
			                   
				             <select name="ch">
                             <option value="0"> 0 </OPTION> 
							 <option value="1"> 1 </OPTION>
				             <option value="2"> 2 </OPTION> 
							 <option value="3"> 3 </OPTION>
				             <option value="4"> 4 </OPTION>
							 <option value="5"> 5 </OPTION>
				             </select></div>
							
							<div class="no"><br>
							 STATUS :
			                   
				             <select name="status">
                             <option value="Single"> Single </OPTION>
				             <option value="Return"> Return </OPTION>
				             </select></div><br>
							 <div class="rat"><center>
							   Single RS:4.79<br>
							   Return RS:9.58
							 </div>
							
							     <div class="back">
							 <button type="button" VALUE="Back" onClick="history.go(-1);"><b>Back</button>
							   </div><br>
							   <div class="sub">
							    <button type="submit"><b>Submit</button>
                             </div>
</form>
</header>
							    
						
							
			<footer>
		
        <div class="f1">&copy;2021 | E- Ticket System For Local Train</div>
        <div class="f2">All Rights Reserved</div>
    </footer>

</body>
</html>
<?php 
}else{
     header("Location: Conform Details.php");
     exit();
}
 ?>