<?php
    session_start();

    if (!isset($_SESSION['useridx'])) {
    header("Location: login_page.php");
    exit();
    }
    $useridx = $_SESSION['useridx'] ;

	include 'set_connection_params.php';
	try {
		$pdo = new PDO($dsn, $username, $password);
	} 
	catch(PDOException $e) {
		echo "Connection to db failed: " . $e->getMessage();
	exit();
  }

$result = $pdo->prepare("
    SELECT 
        Orders.ORDER_ID,
        Orders.ORDER_STATUS,
        Inventory.PROD_NAME,
        Inventory.PRICE,
        OrderContains.ORDER_QTY
    FROM Orders
    JOIN OrderContains 
        ON Orders.ORDER_ID = OrderContains.ORDER_ID
    JOIN Inventory
        ON OrderContains.PROD_ID = Inventory.PROD_ID
    WHERE Orders.CUSTOMER_ID = ? 
    ORDER BY Orders.ORDER_ID
    ");

$result->execute([$useridx]);
?>

<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Order Tracking</title>
</head>

<body class="page">
    <h1 class="title">My Orders</h1>

<?php
$current_order = null;
$order_total = 0;
$grand_total = 0;
$found = false;

foreach ($result as $row) {
    $found = true;

    if ($current_order != $row['ORDER_ID']) {

        if ($current_order !== null) {
            echo "<tr>
                    <td colspan='3'><strong>Order Total</strong></td>
                    <td><strong>$" . number_format($order_total, 2) . "</strong></td>
                  </tr>";
            echo "</table><br>";
        }

        $current_order = $row['ORDER_ID'];
        $order_total = 0;

        echo "<h3 class='table-title'>Order #{$current_order} ({$row['ORDER_STATUS']})</h3>";

        echo "<table border class='account-table'>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>";
    }

    $item_total = $row['ORDER_QTY'] * $row['PRICE'];
    $grand_total += $item_total;
    $order_total += $item_total;

    echo "<tr>
            <td>{$row['PROD_NAME']}</td>
            <td>{$row['ORDER_QTY']}</td>
            <td>\${$row['PRICE']}</td>
            <td>\$" . number_format($item_total, 2) . "</td>
          </tr>";
}

if ($current_order !== null) {
    echo "<tr>
            <td colspan='3'><strong>Order Total</strong></td>
            <td><strong>$" . number_format($order_total, 2) . "</strong></td>
          </tr>";
    echo "</table>";
}

if (!$found) {
    echo "<p class='error'>No orders found.</p>";
}

if ($found) {
    echo "<h2>Orders Total: $" . number_format($grand_total, 2) . "</h2>";
}
?>

<div class="nav-bar">
    <a href="home_page.php" class="nav-link"> ← Back to Home</a>
</div>

</body>
</html>
