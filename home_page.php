<?php
// Start session so we can track logged-in user  
session_start();

// Redirect if not logged in
if (!isset($_SESSION['useridx'])) {
    header("Location: login_page.php");
    exit(); // stop script execution after redirect
}

// DB connection logins 
include 'set_connection_params.php';

// Create PDO connection to MariaDB 
$pdo = new PDO($dsn, $username, $password);

//make it show it will show errors just in case 
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// ADD TO CART SECTION (MAIN LOGIC FOR HOME PAGE )
if (isset($_POST['add_to_cart'])) {

    // Get product ID from form submission
    $prod_id = $_POST['prod_id'];

    // Get currently logged-in user from session
    $user = $_SESSION['useridx'];

    // Check if this product already exists in user's cart
    $sql = "SELECT ORDER_QTY FROM CartContains 
            WHERE CUSTOMER_ID = :user AND PROD_ID = :prod";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':user' => $user,':prod' => $prod_id]);

    // If product already exists in cart, increase quantity
    if ($stmt->fetch()) {
        $sql = "UPDATE CartContains 
                SET ORDER_QTY = ORDER_QTY + 1 
                WHERE CUSTOMER_ID = :user AND PROD_ID = :prod";
    } else {
        // Otherwise, insert new product into cart with quantity 1
        $sql = "INSERT INTO CartContains (CUSTOMER_ID, PROD_ID, ORDER_QTY)
                VALUES (:user, :prod, 1)";
    }

    // Execute insert or update query
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':user' => $user,
        ':prod' => $prod_id
    ]);
}

// Query to retrieve all products from Inventory table
$sql = "SELECT * FROM Inventory";

// Prepare and execute query
$call = $pdo->prepare($sql);
$call->execute();

// Fetch all products as associative array for display
$items = $call->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body class="page">

<h2 class="title">Welcome, <?php echo $_SESSION['useridx']; ?></h2>

<nav class="nav-bar">
    <a href="cart.php" class="nav-link">Cart</a> |
    <a href="order_tracking.php" class="nav-link">Order Tracking</a>
</nav>

<hr>

<h3 class="title">Products</h3>

<div class="container">

<?php foreach ($items as $item): ?>

    <div class="card">

        <h4 class="product-name"><?php echo $item['PROD_NAME']; ?></h4>

        <div class="img-container">
            <img class="product-img" src="<?php echo $item['IMG_URL']; ?>" alt="Image of <?php echo $item['PROD_NAME']; ?>">
        </div>

        <p>Type: <?php echo $item['PROD_TYPE']; ?></p>

        <p>Price: $<?php echo $item['PRICE']; ?></p>

        <p>Stock: <?php echo $item['PROD_QTY']; ?></p>

        <form method="POST" action="alternate_view.php">
            <input type="hidden" name="prod_id" value="<?php echo $item['PROD_ID']; ?>">
            <button type="submit" name="see_details"  class="submit-btn" >See Details</button>
        </form>
		

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

<?php endforeach; ?>

</div>

</body>
</html>
