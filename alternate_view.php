<?php
//start a session
session_start();

//should only work if it was accessed by posting the form from the homepage
//otherwise, send to login
if($_SERVER["REQUEST_METHOD"] == "POST"){
	//connect to database
	include 'set_connection_params.php';
	try { // if something goes wrong, an exception is thrown
		$pdo = new PDO($dsn, $username, $password);
	}
	catch(PDOException $e) { // handle that exception
		echo "Connection to database failed: " . $e->getMessage();
	}
	
	//read login info
	$user = $_SESSION['useridx'];
	//read product to display on this page
	$prod_id = $_POST['prod_id'];
	
	$sql = "SELECT * FROM Inventory WHERE PROD_ID = :prod_id";

	// Prepare and execute query
	$call = $pdo->prepare($sql);
	$call->execute([":prod_id" => $prod_id]);

	// Fetch all products as associative array for display
	$item = $call->fetch(PDO::FETCH_ASSOC);
	
	echo "<p>Type: " . $item['PROD_TYPE'] . "</p>";
	echo "<p>Price: $" . $item['PRICE'] . "</p>";
	echo "<p>Stock: " . $item['PROD_QTY'] . "</p>";
	echo "<p>Description: " . $item['PROD_DESC'] . "</p>";
	echo "<img src='" . $item['IMG_URL'] . "' alt='Image of " . $item['PROD_NAME'] . "'>";
	
	echo "<table cellpadding='20' cellspacing='0' border='solid black'>";
		echo "<tr><th><a href='home_page.php'>Back To Homepage</a></th></tr>";
	echo "</table>";
} else{
	//page not accessed correctly, send to login
	header('Location: login_page.php');
}
?>