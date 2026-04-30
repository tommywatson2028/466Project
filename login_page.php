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
		
		<table class="account-table" cellpadding="20" cellspacing="0">
			<tr>
				<th>
					<a href="create_account.php" class="account-link">Create Account</a>
				</th>
			</tr>
		</table>
		
		<br>
		
		<h1> Buttons to Bypass Authentication: </h1>
		<form method="POST" action="login_handler.php" class="quick-form"> 
			<p class="quick-label">Main homepage, cart, and order status</p>
			<input type="hidden" name="useridx" value="UrMom">
			<input type="hidden" name="userpass" value="IsFat">
			<input type="submit" value="Log in as user" class="submit-btn">
		</form>
		
		<form method="POST" action="login_handler.php" class="quick-form"> 
			<p class="quick-label">Order fulfillment</p>
			<input type="hidden" name="useridx" value="Emp">
			<input type="hidden" name="userpass" value="Emp">
			<input type="submit" value="Log in as employee" class="submit-btn">
		</form>
		
		<form method="POST" action="login_handler.php" class="quick-form"> 
			<p class="quick-label">Inventory and order fulfillment</p> 
			<input type="hidden" name="useridx" value="Owner">
			<input type="hidden" name="userpass" value="Owner">
			<input type="submit" value="Log in as owner" class="submit-btn">
		</form>
		
		<br>
	</body>
</html>
