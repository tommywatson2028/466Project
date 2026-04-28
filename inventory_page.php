<?php
session_start();

if(!isset($_SESSION['useridx'])) {
	header('Location: login_page.php');
	exit();
}

include 'set_connection_params.php';
try {
	$pdo = new PDO($dsn, $username, $password);
} catch(PDOException $e) {
	echo "Connection to db failed: " . $e->getMessage();
	exit();
  }

$sql = "SELECT IS_OWNER, IS_EMPLOYEE FROM Users WHERE USER_IDX = :useridx";
$prep = $pdo->prepare($sql);
$prep->execute([':useridx' => $_SESSION['useridx']]);
$user = $prep->fetch();

if(!$user['IS_OWNER']) {
	if($user['IS_EMPLOYEE']) {
		header('Location: order_fulfillment.php');
		exit();
	} else { 
		header('Location: login_page.php');
		exit();
	}
}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Inventory</title>
		<link rel="stylesheet" href="styles.css">
		<style> table, th, td { border: 1px solid black; } </style>
	</head>
	
	<body class="adm-page">
		<h1 class="title">INVENTORY</h1>
		<nav class="nav-bar">
			<a href="order_fulfillment.php" class="nav-link">Order Fullfillment</a>
		</nav>
		<hr>

		<div class="container">

		<div class="adm-card">
		<h1 class="table-title">In Stock</h1>
		<?php
		$sql = "SELECT PROD_ID, PROD_NAME, PROD_DESC, PROD_TYPE, PRICE, PROD_QTY FROM Inventory WHERE PROD_QTY > 0";
		$result = $pdo->prepare($sql);
		$result->execute();
        	if($row = $result->fetch(PDO::FETCH_ASSOC)){
            		echo "<table cellspacing=0 cellpadding=10 border=1 align=center>";
            		echo "<tr>";
            		foreach(array_keys($row) as $header){
                		echo "<th bgcolor=grey>" . $header . "</th>";
            		}
            		echo "</tr>";
            		do {
                		echo "<tr>";
				foreach($row as $col => $entry){
			        	echo "<td bgcolor=lightgrey>" . $entry . "</td>";
                		}
				echo "</tr>";

            		} while($row = $result->fetch(PDO::FETCH_ASSOC));
            		echo "</table>";
        	}
		?>	
		</div>
		
		<div class="adm-card">
		<h1 class="table-title">Out of Stock</h1>
		<?php
                $sql = "SELECT PROD_ID, PROD_NAME, PROD_DESC, PROD_TYPE, PRICE, PROD_QTY FROM Inventory WHERE PROD_QTY < 1";
                $result = $pdo->prepare($sql);
                $result->execute();
		if($row = $result->fetch(PDO::FETCH_ASSOC)){
                        echo "<table cellspacing=0 cellpadding=10 border=1 align=center>";
                        echo "<tr>";
                        foreach(array_keys($row) as $header){
                                echo "<th bgcolor=grey>" . $header . "</th>";
                        }
                        echo "</tr>";
                        do {
                                echo "<tr>";
                                foreach($row as $col => $entry){
                                        echo "<td bgcolor=lightgrey>" . $entry . "</td>";
                                }
                                echo "</tr>";

                        } while($row = $result->fetch(PDO::FETCH_ASSOC));
			echo "</table>";
                }
		?>
		</div>

		</div>
	</body>
</html>
