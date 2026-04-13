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

$sql = "SELECT IS_OWNER FROM Users WHERE USER_IDX = :useridx";
$prep = $pdo->prepare($sql);
$prep->execute([':useridx' => $_SESSION['useridx']]);
$user = $prep->fetch();

if(!$user['IS_OWNER']) {
	header('Location: login_page.php');
	exit();
}

?>

<html>
	<head>
		<title>Inventory</title>
		<style> table, th, td { border: 1px solid black; } </style>
	</head>
	
	<body>
		<a href="order_fulfillment.php"><h2>To Order Fullfillment</h2></a>
		<?php
		$sql = "SELECT PROD_ID, PROD_NAME, PROD_DESC, PROD_TYPE, PRICE, PROD_QTY FROM Inventory";
		$result = $pdo->prepare($sql);
		$result->execute();
        	if($row = $result->fetch(PDO::FETCH_ASSOC)){
            		echo "<table cellspacing=0 cellpadding=10 border=1>";
            		echo "<tr>";
            		foreach(array_keys($row) as $header){
                		echo "<th bgcolor=grey>" . $header . "</th>";
            		}
            		echo "</tr>";
            		do {
                		echo "<tr>";
				foreach($row as $col => $entry){
					if($col === 'PROD_QTY') {
						$color = $entry > 0 ? "green" : "red";
						echo "<td bgcolor=\"$color\">" . $entry . "</td>";
					} else {
                    				echo "<td bgcolor=lightgrey>" . $entry . "</td>";
					}
                		}
                		echo "</tr>";
            		} while($row = $result->fetch(PDO::FETCH_ASSOC));
            		echo "</table>";
        	}
		?>	
	</body>
</html>
