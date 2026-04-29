<html>
	<head>
		<title> Login </title>
		<link rel="stylesheet" href="styles.css">
	</head>
	
	<body class="page">
		<h1 class="title"> BLOCKBUSTER  </h1>

		<?php
			// show error if login failed
			if(isset($_GET['failed'])){
				echo "<p class='error'>Login attempt failed, please try again</p>";
			}
		?>
		
		<form method="POST" action="login_handler.php" class="login-form"> 
			<label>Username:</label><br>
			<input type="text" name="useridx" class="input-field"><br>

			<label>Password:</label><br>
			<input type="password" name="userpass" class="input-field"><br>

			<input type="submit" class="submit-btn"><br>
		</form>
		
		<br>
		<h1> use this to access main homepage, cart, and order status</h1>
		<form method="POST" action="login_handler.php"> 
			<input type="hidden" name="useridx" value="UrMom"><br>
			<input type="hidden" name="userpass" value="IsFat"><br>
			<input type="submit" value="Log in as user" class="submit-btn"><br>
		</form>
		
		<h1> use this to access main inventory and order fufilment </h1>
		<form method="POST" action="login_handler.php"> 
			<input type="hidden" name="useridx" value="Emp"><br>
			<input type="hidden" name="userpass" value="Emp"><br>
			<input type="submit" value="Log in as employee" class="submit-btn"><br>
		</form>
		
		<h1> use this to access order fufilment </h1>
		<form method="POST" action="login_handler.php"> 
			<input type="hidden" name="useridx" value="Owner"><br>
			<input type="hidden" name="userpass" value="Owner"><br>
			<input type="submit" value="Log in as owner" class="submit-btn"><br>
		</form>
		
		<br>
		
		<table class="account-table" cellpadding="20" cellspacing="0">
			<tr>
				<th>
					<a href="create_account.php" class="account-link">Create Account</a>
				</th>
			</tr>
		</table>
	</body>
</html>
