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

$sql = "SELECT IS_EMPLOYEE FROM Users WHERE USER_IDX = :useridx";
$prep = $pdo->prepare($sql);
$prep->execute([':useridx' => $_SESSION['useridx']]);
$user = $prep->fetch();

if(!$user['IS_EMPLOYEE']) {
        header('Location: login_page.php');
        exit();
}

?>

<?php if(isset($_POST['submit_ss'])):
	$id = $_POST['o_id'];
	$st = $_POST['o_stat'];
	$stmt = $pdo->prepare("UPDATE Orders SET ORDER_STATUS = ? WHERE ORDER_ID = ? ");
	$stmt->execute([$st, $id]);
	$ss_msg = "Updated Order: $id status to: $st.";
endif; ?>

<?php if(isset($_POST['submit_sn'])):
	$id = $_POST['o_id'];
	$nt = $_POST['o_note'];
	$stmt = $pdo->prepare("UPDATE Orders SET ORDER_NOTE = ? WHERE ORDER_ID = ? ");
	$stmt->execute([$nt, $id]);
        $sn_msg = "Updated Order: $id Note to: $nt.";
endif; ?>

<!DOCTYPE html>
<html>
        <head>
		<title>Order Fulfillment</title>
		<link rel="stylesheet" href="styles.css">
        </head>

	<body class="adm-page">
		<h1 class="title"> ORDER FULFILLMENT</h1>
		<nav class="nav-bar">
			<a href="inventory_page.php" class="nav-link">Inventory</a>
			
		</nav>
		<hr>

		<div class="container">	

		<div class="adm-card">	
		<h1 class="table-title">OUTGOING ORDERS</h1>
		<?php
                $sql = "SELECT * FROM Orders WHERE ORDER_STATUS = 'Processing' OR ORDER_STATUS = 'Shipped'";
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
					if($col === 'CONTACT_EMAIL' && !empty($entry)) {
						echo "<td bgcolor=lightgrey><a href='mailto:" . htmlspecialchars($entry) . "'>" . htmlspecialchars($entry) . "</a></td>";
					} else {
						echo "<td bgcolor=lightgrey>" . $entry . "</td>";
					}
                                }
                                echo "</tr>";
                        } while($row = $result->fetch(PDO::FETCH_ASSOC));
			echo "</table>";
			
                }
		?>	
		</div>

		<div class="adm-card">
		<h1 class="table-title">COMPLETED ORDERS</h1>
                <?php
                $sql = "SELECT * FROM Orders WHERE ORDER_STATUS = 'Complete'";
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
                                        if($col === 'CONTACT_EMAIL' && !empty($entry)) {
                                                echo "<td bgcolor=lightgrey><a href='mailto:" . htmlspecialchars($entry) . "'>" . htmlspecialchars($entry) . "</a></td>";
                                        } else {
                                                echo "<td bgcolor=lightgrey>" . $entry . "</td>";
                                        }
                                }
                                echo "</tr>";
                        } while($row = $result->fetch(PDO::FETCH_ASSOC));
			echo "</table>";
                }
		?>
		</div>

		<div class="adm-card">
		<h3 class="form-title">SEE ORDER CONTENTS</h3>
		<?php
		$orders =  $pdo->query("SELECT ORDER_ID FROM Orders ORDER BY ORDER_ID")->fetchALL(PDO::FETCH_ASSOC);
		?>
		<form method="post">
			<span class="form-desc">ORDER ID</span> <select class="submit-btn" name="o_id">
                                <?php foreach ($orders as $o): ?>
                                <option value="<?= htmlspecialchars($o['ORDER_ID']) ?>" 
                                <?= (isset($_POST['o_id']) && $_POST['o_id'] === $o['ORDER_ID']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($o['ORDER_ID']) ?>
                                </option>
                                <?php endforeach; ?>
			</select>
			
			<input type="submit" name="submit_so" value="Submit" class="submit-btn">		
		</form>
		</div>
		
		<?php if(isset($_POST['submit_so'])):
			$id = $_POST['o_id'];
			echo "<div class\"adm-card\">";
			echo "<h3 class=\"table-title\">Order $id</h3>";
        		$result = $pdo->prepare("SELECT Inventory.PROD_NAME, Inventory.PRICE, OrderContains.ORDER_QTY
						FROM Orders 
						JOIN OrderContains ON Orders.ORDER_ID = OrderContains.ORDER_ID
    						JOIN Inventory ON OrderContains.PROD_ID = Inventory.PROD_ID
						WHERE Orders.ORDER_ID = ? 
						ORDER BY Orders.ORDER_ID");
			$result->execute([$id]);
			if($row = $result->fetch(PDO::FETCH_ASSOC)) {
				echo "<table cellspacing=0 cellpadding=10 border=1>";
				echo "<tr>";
				foreach(array_keys($row) as $header) {
					echo "<th bgcolor=grey>" . $header . "</th>";
				}
				echo "</tr>";
				do {
					echo "<tr>";
					foreach($row as $col => $entry) {
						echo "<td bgcolor=lightgrey>" . $entry . "</td>";
					}
					echo "</tr>";
				} while($row = $result->fetch(PDO::FETCH_ASSOC));
				echo "</table>";
			echo "</div>";
			}
		endif; ?>

	
		<div class="adm-card">
		<h3 class="form-title">SET ORDER STATUS</h3>
                <?php
                $orders = $pdo->query("SELECT ORDER_ID FROM Orders ORDER BY ORDER_ID")->fetchAll(PDO::FETCH_ASSOC);
                ?>
		<form method="post">
                	<span class="form-desc">ORDER ID</span> <select class="submit-btn" name="o_id">
                		<?php foreach ($orders as $o): ?>
                		<option value="<?= htmlspecialchars($o['ORDER_ID']) ?>"
                        	<?= (isset($_POST['o_id']) && $_POST['o_id'] === $o['ORDER_ID']) ? 'selected' : '' ?>>
                        	<?= htmlspecialchars($o['ORDER_ID']) ?>
                		</option>
				<?php endforeach; ?>
			</select>

                	<span class="form-desc">STATUS</span> <select class="submit-btn" name="o_stat">
				<option value="Complete">Complete</option>
				<option value="Processing">Processing</option>
				<option value="Shipped">Shipped</option>
			</select>

                	<input type="submit" name="submit_ss" value="Set" class="submit-btn">
		</form>
		<?php if(isset($ss_msg)) echo "<p class=\"form-desc\">$ss_msg</p>"; ?>
		</div>

		<div class="adm-card">	
		<h3 class="form-title">LEAVE ORDER NOTE</h3>
                <?php
                $orders = $pdo->query("SELECT ORDER_ID FROM Orders ORDER BY ORDER_ID")->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <form method="post">
                	<span class="form-desc">ORDER ID</span> <select class="submit-btn" name="o_id">
                		<?php foreach ($orders as $o): ?>
                		<option value="<?= htmlspecialchars($o['ORDER_ID']) ?>"
                        	<?= (isset($_POST['o_id']) && $_POST['o_id'] === $o['ORDER_ID']) ? 'selected' : '' ?>>
                        	<?= htmlspecialchars($o['ORDER_ID']) ?>
                		</option>
                		<?php endforeach; ?>
			</select>

			<span class="form-desc">NOTE</span> <input type="text" name="o_note" value=""> 

			<input type="submit" name="submit_sn" value="Set" class="submit-btn">
		</form>
		<?php if(isset($sn_msg)) echo "<p class=\"form-desc\">$sn_msg</p>"; ?>
		</div>
		
		</div>
		
	</body>
</html>

