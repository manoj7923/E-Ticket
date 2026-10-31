
		
		function sinup(){

			var user=document.getElementById('user').value;
			var pass=document.getElementById('pass').value;
			var email=document.getElementById('email').value; 
			
			localStorage.setItem("name1",user)
			localStorage.setItem("pass1",pass)
			localStorage.setItem("email1",email)
			
			
			
if(user == ""){
				document.getElementById('user').innerHTML =" ** Please fill the username field";
				return false;
			}
			if((user.length <= 6) || (user.length > 20)) {
				document.getElementById('username').innerHTML =" ** Username lenght must be between 6 and 20";
				return false;	
			}
			if(!isNaN(user)){
				document.getElementById('username').innerHTML =" ** only characters are allowed";
				return false;
			}

if(pass == ""){
				document.getElementById('passwords').innerHTML =" ** Please fill the password field";
				return false;
			}
			if((pass.length <= 5) || (pass.length > 20)) {
				document.getElementById('passwords').innerHTML =" ** Passwords lenght must be between  5 and 20";
				return false;	
			}
if(email == ""){
				document.getElementById('emailids').innerHTML =" ** Please fill the email idx` field";
				return false;
			}
			if(emails.indexOf('@') <= 0 ){
				document.getElementById('emailids').innerHTML =" ** @ Invalid Position";
				return false;
			}

			if((emails.charAt(emails.length-4)!='.') && (emails.charAt(emails.length-3)!='.')){
				document.getElementById('emailids').innerHTML =" ** . Invalid Position";
				return false;
			}
		}
	

