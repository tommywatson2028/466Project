<?php
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST"){

	include 'set_connection_params.php';

	try {
		$pdo = new PDO($dsn, $username, $password);
	}
	catch(PDOException $e) {
		echo "<p class='error'>Connection failed: " . $e->getMessage() . "</p>";
	}

	$user = $_SESSION['useridx'];
	$prod_id = $_POST['prod_id'];

	$sql = "SELECT * FROM Inventory WHERE PROD_ID = :prod_id";
	$call = $pdo->prepare($sql);
	$call->execute([":prod_id" => $prod_id]);

	$item = $call->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Details</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body class="page">

<h2 class="title"><?php echo $item['PROD_NAME']; ?></h2>

<div class="card" style="margin: 0 auto; width: 300px;">

    <div class="alt-img-container">
        <img class="product-img" src="<?php echo $item['IMG_URL']; ?>" 
             alt="Image of <?php echo $item['PROD_NAME']; ?>">
    </div>

    <p class="product-desc"><?php echo $item['PROD_DESC']; ?></p>

    <p>Type: <?php echo $item['PROD_TYPE']; ?></p>

    <p>Price: $<?php echo $item['PRICE']; ?></p>

    <p>Stock: <?php echo $item['PROD_QTY']; ?></p>

	<?php if ($item['PROD_QTY'] > 0): ?>
		<form method="POST">
			<input type="hidden" name="prod_id" value="<?php echo $item['PROD_ID']; ?>">
			<button type="submit" name="add_to_cart" class="submit-btn">
				Add to Cart
			</button>
		</form>
	<?php else: ?>
		<button class="submit-btn disabled-btn" disabled>
			Out of Stock
		</button>
	<?php endif; ?>
</div>

<br>

<table class="account-table">
	<tr>
    	<td> <a href="home_page.php" class="account-link">Back To Homepage</a> </td>
    <tr>
</table>

</body>
</html>

<?php
} else{
	header('Location: login_page.php');
}
?>
