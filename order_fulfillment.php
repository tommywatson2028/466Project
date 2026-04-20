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

<html>
        <head>
                <title>Order Fulfillment</title>
        </head>

        <body>
		<h1> ORDER FULFILLMENT SYSTEM </h1>
		
		<h2>OUTGOING ORDERS</h2>
		<?php
                $sql = "SELECT * FROM Orders WHERE ORDER_STATUS = 'Processing' OR ORDER_STATUS = 'Shipped'";
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
                                        echo "<td bgcolor=lightgrey>" . $entry . "</td>";
                                }
                                echo "</tr>";
                        } while($row = $result->fetch(PDO::FETCH_ASSOC));
                        echo "</table>";
                }
                ?>

		<h2>COMPLETED ORDERS</h2>
                <?php
                $sql = "SELECT * FROM Orders WHERE ORDER_STATUS = 'Complete'";
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
                                        echo "<td bgcolor=lightgrey>" . $entry . "</td>";
                                }
                                echo "</tr>";
                        } while($row = $result->fetch(PDO::FETCH_ASSOC));
                        echo "</table>";
                }
                ?>



		<h3>SET ORDER STATUS</h3>
                <?php
                $orders = $pdo->query("SELECT ORDER_ID FROM Orders ORDER BY ORDER_ID")->fetchAll(PDO::FETCH_ASSOC);
                ?>
		<form method="post">
                	Order_ID <select name="o_id">
                		<?php foreach ($orders as $o): ?>
                		<option value="<?= htmlspecialchars($o['ORDER_ID']) ?>"
                        	<?= (isset($_POST['o_id']) && $_POST['o_id'] === $o['ORDER_ID']) ? 'selected' : '' ?>>
                        	<?= htmlspecialchars($o['ORDER_ID']) ?>
                		</option>
				<?php endforeach; ?>
			</select>

                	Status <select name="o_stat">
				<option value="Complete">Complete</option>
				<option value="Processing">Processing</option>
				<option value="Shipping">Shipped</option>
			</select>

                	<input type="submit" name="submit_ss" value="Set">
		</form>

                <?php if (isset($_POST['submit_ss'])):
                        $id = $_POST['o_id'];
                        $st = $_POST['o_stat'];
                        $stmt = $pdo->prepare("UPDATE Orders SET ORDER_STATUS = ? WHERE ORDER_ID = ? ");
                        $stmt->execute([$st, $id]);
                        echo "<p>Updated Order: $id status to: $st.</p>";
		endif; ?>

		
		<h3>LEAVE ORDER NOTE</h3>
                <?php
                $orders = $pdo->query("SELECT ORDER_ID FROM Orders ORDER BY ORDER_ID")->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <form method="post">
                	Order_ID <select name="o_id">
                		<?php foreach ($orders as $o): ?>
                		<option value="<?= htmlspecialchars($o['ORDER_ID']) ?>"
                        	<?= (isset($_POST['o_id']) && $_POST['o_id'] === $o['ORDER_ID']) ? 'selected' : '' ?>>
                        	<?= htmlspecialchars($o['ORDER_ID']) ?>
                		</option>
                		<?php endforeach; ?>
			</select>

			Note <input type="text" name="o_note" value=""> 

			<input type="submit" name="submit_sn" value="Set">
		</form>

                <?php if (isset($_POST['submit_sn'])):
                        $id = $_POST['o_id'];
                        $nt = $_POST['o_note'];
                        $stmt = $pdo->prepare("UPDATE Orders SET ORDER_NOTE = ? WHERE ORDER_ID = ? ");
                        $stmt->execute([$nt, $id]);
                        echo "<p>Updated Order: $id Note to: $nt.</p>";
                endif; ?>

	</body>
</html>

