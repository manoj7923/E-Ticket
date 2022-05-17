<!DOCTYPE html>
<html>
<head>
	<title>Admin Login</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   
</head>
<body>	 
    
     <form action="login1.php" method="post">
     	<h2> Admin Login</h2>
     	<?php if (isset($_GET['error'])) { ?>
     		<p class="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>
     	<label>Admin ID</label>
     	<input type="text" name="uname" placeholder="Admin ID"><br>

     	<label> Admin Password</label>
     	<input type="password" name="password" placeholder="Password"><br>

       <button type="submit">Login</button>
     
		
     </form><br>
	   <a href="index.php">User Login</a>
</body>
</html>

