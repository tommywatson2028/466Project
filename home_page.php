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

    <style>
        .container {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;  
            gap: 20px;
        }

        .card {
            border: 1px solid #ccc;
            padding: 15px;
            width: 200px;
            border-radius: 8px;
        }
    </style>
</head>

<body>

<!-- Display logged-in username -->
<h2>Welcome, <?php echo $_SESSION['useridx']; ?></h2>

<!-- Navigation links to other pages -->
<nav>
    <a href="cart.php">Cart</a> |
    <a href="order_tracking.php">Order Tracking</a>
</nav>

<hr>

<h3>Products</h3>

<!-- Flexbox container for product cards -->
<div class="container">

<?php foreach ($items as $item): ?>

    <div class="card">

        <h4><?php echo $item['PROD_NAME']; ?></h4>

        <p>Type: <?php echo $item['PROD_TYPE']; ?></p>

        <p>Price: $<?php echo $item['PRICE']; ?></p>

        <p>Stock: <?php echo $item['PROD_QTY']; ?></p>

        <form method="POST" action="alternate_view.php">
            <input type="hidden" name="prod_id" value="<?php echo $item['PROD_ID']; ?>">
            <button type="submit" name="see_details">See Details</button>
        </form>
		
        <form method="POST">
            <input type="hidden" name="prod_id" value="<?php echo $item['PROD_ID']; ?>">
            <button type="submit" name="add_to_cart">Add to Cart</button>
        </form>

    </div>

<?php endforeach; ?>

</div>

</body>
</html>
