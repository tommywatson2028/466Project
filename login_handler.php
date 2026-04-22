<?php
//start a session
session_start();

//login handler should only work if it was accessed by posting the form from the login page
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
	$useridx = $_POST['useridx'];
	$userpass = $_POST['userpass'];

	//check if login info is in the database
	//if exists, handle the login and send the user to the right page
	//if not, send user back to login
	$sql = "SELECT * FROM Users WHERE USER_IDX = :useridx AND USER_PASS = :userpass";
	$result = $pdo->prepare($sql);
	$result->execute([':useridx' => $useridx, ':userpass' => $userpass]);
	if($row = $result->fetch()){
		//store the useridx to be accessible by each page
		$_SESSION['useridx'] = $useridx;
		
		if ($row['IS_OWNER']) {
			//send owner to view inventory
			header('Location:  inventory_page.php');
		} elseif ($row['IS_EMPLOYEE']) {
			//send employee to order fulfillment
			header('Location:  order_fulfillment.php');
		} else {
			//send customer to storefront homepage
			header('Location:  home_page.php');
		}
	} else{
		//login failed send back to login page
		header('Location: login_page.php?failed=1');
	}
} else{
	//page not accessed correctly, send to login
	header('Location: login_page.php');
}
?>