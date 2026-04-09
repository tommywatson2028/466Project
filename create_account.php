<html>
	<head>
		<title> Create Account </title>
	</head>
	
	<h1>Create a New Account</h1>
	
	<form method="POST" action="">
		<p>Username (must be unique)</p><input name="useridx" type="text"><br>
		<p>Password</p><input name="userpass" type="text"><br>
		<input type="submit">
	</form>
	
	<?php
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			$useridx = $_POST["useridx"];
			$userpass = $_POST["userpass"];
			
			//connect to database
			include 'set_connection_params.php';
			try { // if something goes wrong, an exception is thrown
				$pdo = new PDO($dsn, $username, $password);
			}
			catch(PDOException $e) { // handle that exception
				echo "Connection to database failed: " . $e->getMessage();
			}
		
			//check if the current username already exists
			//if it does, tell user to resubmit form
			$sql = "SELECT USER_IDX FROM Users WHERE USER_IDX = :useridx";
			$result = $pdo->prepare($sql);
			$result->execute([':useridx' => $useridx]);
			$existing_useridx = $result->fetchColumn();
			
			if($existing_useridx === false || $existing_useridx === null){
				$sql = "INSERT INTO Users (USER_IDX, USER_PASS) VALUES (:useridx,:userpass)";
				$prepared = $pdo->prepare($sql);
				$prepared->execute([':useridx' => $useridx,':userpass' => $userpass]);
				echo "<p>New account with username ". $useridx ." successfully added</p>";
			} else{
				echo "<p>Provided username already exists, please resubmit the form with a different username</p>";
			}
		}
	?>
</html>