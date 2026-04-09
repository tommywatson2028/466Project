<html>
	<head>
		<title> Login </title>
	</head>
	
	<body>
		<h1> This Is The Login Page </h1>

		<?php
			//if the user is coming back from a failed login attempt by the handler, show a message
			if(isset($_GET['failed'])){
				echo "<p style=\"color:red;\"><b>Login attempt failed, please try again</b></p>";
			}
		?>
		
		<form method="POST" action="login_handler.php"> 
			Username: <input type="text" name="useridx"><br>
			Password: <input type="password" name="userpass"><br>
			<input type="submit"><br>
		</form>
		
		<table cellpadding="20" cellspacing="0" border="solid black">
			<tr>
				<th><a href="https://www.reddit.com/r/copypasta/comments/gpmpwu/reddit_am_i_the_arsehole/">Create Account</a></th>
			</tr>
		</table>
	</body>
</html>