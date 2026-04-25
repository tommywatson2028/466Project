<html>
	<head>
		<title> Create Account </title>
		<link rel="stylesheet" href="styles.css">
	</head>
	
	<body class="page">

	<h1 class="title">Create a New Account</h1>
	
	<form method="POST" action="" class="login-form">
		<p>Username (must be unique)</p>
		<input name="useridx" type="text" class="input-field"><br>

		<p>Password</p>
		<input name="userpass" type="password" class="input-field"><br>

		<input type="submit" class="submit-btn">
	</form>
	
	<?php
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			$useridx = $_POST["useridx"];
			$userpass = $_POST["userpass"];
			
			//connect to database
			include 'set_connection_params.php';
			try {
				$pdo = new PDO($dsn, $username, $password);
			}
			catch(PDOException $e) {
				echo "<p class='error'>Connection failed: " . $e->getMessage() . "</p>";
			}
		
			//check if username already exists
			$sql = "SELECT USER_IDX FROM Users WHERE USER_IDX = :useridx";
			$result = $pdo->prepare($sql);
			$result->execute([':useridx' => $useridx]);
			$existing_useridx = $result->fetchColumn();
			
			if($existing_useridx === false || $existing_useridx === null){
				$sql = "INSERT INTO Users (USER_IDX, USER_PASS) VALUES (:useridx,:userpass)";
				$prepared = $pdo->prepare($sql);
				$prepared->execute([':useridx' => $useridx,':userpass' => $userpass]);

				echo "<p>New account with username $useridx successfully added</p>";
			} else{
				echo "<p class='error'>Username already exists, please choose another</p>";
			}
		}
	?>
	
	<table class="account-table" cellpadding="20" cellspacing="0">
		<tr>
			<th>
				<a href="login_page.php" class="account-link">Return to Login</a>
			</th>
		</tr>
	</table>

	</body>
</html>
