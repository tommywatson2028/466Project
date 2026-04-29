<?php
    /* 
        Jesse Llamas Z2070461

        tables -> Users, CartContains, Orders, Inventory, OrderContains

        Cart: 
        • display cart table for the current user 
        • + and - items from the cart
        • form that allows the user to enter checkout info


        on submit 
        -> add order info to orders table, 
        -> move user's items from cart to ordercontains table 
        -> delete user's items from cart


        check User and CartContains, merge with productname WHERE Customer.IDX = User.IDX

        shipping, billing, credit card num, security pin

        when form is submitted, checkout, santize insert, using User.IDX info into orderstable,
        set the order to processing 

        once order is processing, move from cart to orders, use order number, reset cart
    */
            
    // start session and connect to database
    session_start();
    include 'set_connection_params.php';

    try {
        $pdo = new PDO($dsn, $username, $password);
    } catch(PDOException $e) {
        echo "Connection to database failed: " . $e->getMessage();
    }

    // reset checkout unless next was pressed
    if (!isset($_POST['next'])) {
        $_SESSION['checkout'] = false;
    }

    // $useridx = $_SESSION['useridx'];
    $useridx = 'BenDover';

    // handle post requests
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        // handle plus and minus buttons
        if (isset($_POST['action'])) {
            $prod_id = $_POST['prod_id'];

            // get current cart quantity and inventory quantity
            $stmt = $pdo->prepare(
                "SELECT CartContains.ORDER_QTY, Inventory.PROD_QTY
                FROM CartContains
                JOIN Inventory ON CartContains.PROD_ID = Inventory.PROD_ID
                WHERE CartContains.CUSTOMER_ID = :u AND CartContains.PROD_ID = :p"
            );

            $stmt->execute([
                ':u' => $useridx, 
                ':p' => $prod_id
            ]);

            $row = $stmt->fetch();

            // update cart if item exists
            if ($row) {

                // add one item
                if ($_POST['action'] == 'plus' && $row['PROD_QTY'] > 0) {

                    $pdo->prepare(
                        "UPDATE CartContains
                        SET ORDER_QTY = ORDER_QTY + 1
                        WHERE CUSTOMER_ID = :u AND PROD_ID = :p"
                    )->execute([
                        ':u' => $useridx,
                        ':p' => $prod_id
                    ]);

                    $pdo->prepare(
                        "UPDATE Inventory
                        SET PROD_QTY = PROD_QTY - 1
                        WHERE PROD_ID = :p"
                    )->execute([
                        ':p' => $prod_id
                    ]);

                }

                // remove one item
                if ($_POST['action'] == 'minus') {

                    // lower quantity if more than one
                    if ($row['ORDER_QTY'] > 1) {

                        $pdo->prepare(
                            "UPDATE CartContains
                            SET ORDER_QTY = ORDER_QTY - 1
                            WHERE CUSTOMER_ID = :u AND PROD_ID = :p"
                        )->execute([
                            ':u' => $useridx,
                            ':p' => $prod_id
                        ]);


                        $pdo->prepare(
                            "UPDATE Inventory
                            SET PROD_QTY = PROD_QTY + 1
                            WHERE PROD_ID = :p"
                        )->execute([
                            ':p' => $prod_id
                        ]);

                    } else {

                        // delete item if quantity reaches zero
                        $pdo->prepare(
                            "DELETE FROM CartContains
                            WHERE CUSTOMER_ID = :u AND PROD_ID = :p"
                        )->execute([
                            ':u' => $useridx,
                            ':p' => $prod_id
                        ]);

                        $pdo->prepare(
                            "UPDATE Inventory
                            SET PROD_QTY = PROD_QTY + 1
                            WHERE PROD_ID = :p"
                        )->execute([
                            ':p' => $prod_id
                        ]);
                    }
                }
            }
        }

        // check cart before going to payment page
        if (isset($_POST['next'])) {

            $stmt = $pdo->prepare("
                SELECT *
                FROM CartContains
                WHERE CUSTOMER_ID = :u
            ");
            $stmt->execute([':u' => $useridx]);
            $row = $stmt->fetch();

            // move to payment if cart has items
            if ($row) {
                $_SESSION['checkout'] = true;
                header("Location: payment.php");
                exit;
            } else {
                echo "Cart is empty";
            }
        }
    }

    // get cart items
    $stmt = $pdo->prepare("
        SELECT CartContains.PROD_ID, CartContains.ORDER_QTY, Inventory.PROD_NAME, Inventory.PRICE
        FROM CartContains
        JOIN Inventory ON CartContains.PROD_ID = Inventory.PROD_ID
        WHERE CartContains.CUSTOMER_ID = :u
    ");
    $stmt->execute([':u' => $useridx]);
    $items = $stmt->fetchAll();

    $total = 0;

    foreach ($items as $item) {
        $total += $item['PRICE'] * $item['ORDER_QTY'];
    }

?>

<html>
    <head>
        <title>Cart</title>
        <link rel="stylesheet" href="styles.css">
    </head>

    <body class="page">

        <!-- page title -->
        <h1 class="title">Cart</h1>

        <!-- cart item container -->
        <div class="cart-list">

            <!-- loop through cart items -->
            <?php foreach ($items as $item): ?>
                <div class="cart-row">

                    <div class="cart-line">

                        <div class="cart-info">

                            <span class="cart-product-name">
                                <?php echo $item['PROD_NAME']; ?>
                            </span>

                            <span>
                                Qty : <?php echo $item['ORDER_QTY']; ?>
                            </span>

                            <span>
                                Price : $<?php echo $item['PRICE'] * $item['ORDER_QTY']; ?>
                            </span>

                        </div>

                            <div class="cart-actions">

                                <form method="post">
                                    <input type="hidden" name="prod_id" value="<?php echo $item['PROD_ID']; ?>">
                                    <button class="submit-btn" name="action" value="plus">+</button>
                                </form>

                                <form method="post">
                                    <input type="hidden" name="prod_id" value="<?php echo $item['PROD_ID']; ?>">
                                    <button class="submit-btn" name="action" value="minus">-</button>
                                </form>

                            </div>

                    </div>

                </div>
            <?php endforeach; ?>

        </div>

        <div class="panel">
            <h2 class="product-name">Total: $<?php echo number_format($total, 2); ?></h2>
        </div>

        <!-- go to payment page -->
        <div style="margin-top: 20px;">
            <form method="post">
                <button class="submit-btn" type="submit" name="next">Next</button>
            </form>
        </div>

        <br><br>
        
        <div>
            <a class="submit-btn" href="home_page.php">Back to Home Page.</a>
        </div>

    </body>
</html>