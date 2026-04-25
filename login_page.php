<html>
	<head>
		<title> Login </title>
		<link rel="stylesheet" href="styles.css">
	</head>
	
	<body class="page">
		<h1 class="title"> BLOCkBUSTERS  </h1>

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
		
		<table class="account-table" cellpadding="20" cellspacing="0">
			<tr>
				<th>
					<a href="create_account.php" class="account-link">Create Account</a>
				</th>
			</tr>
		</table>
	</body>
</html>
