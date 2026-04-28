<?php

    session_start();
    include 'set_connection_params.php';

    try {
        $pdo = new PDO($dsn, $username, $password);
    } catch(PDOException $e) {
        echo "Connection to database failed: " . $e->getMessage();
    }

    // current user
    $useridx = $_SESSION['useridx'];
    $success = false;

    // cancel payment and return to cart
    if (isset($_POST['cancel'])) {
        $_SESSION['checkout'] = false;
        header("Location: cart.php");
        exit;
    }

    // handle order submit
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit_order'])) {

        // required payment fields
        $required = [
            'contact_email',
            'shipping_address',
            'billing_address',
            'credit_card_num',
            'cvv_num'
        ];

        $missing = false;

        // check for missing fields
        foreach ($required as $field) {
            if (!isset($_POST[$field]) || trim($_POST[$field]) == "") {
                $missing = true;
            }
        }

        // validate fields
        $invalid = false;

        if (!filter_var($_POST['contact_email'], FILTER_VALIDATE_EMAIL)) {
            $invalid = true;
            echo "Invalid email.<br>";
        }

        if (!is_numeric($_POST['credit_card_num'])) {
            $invalid = true;
            echo "Credit card number must only contain numbers.<br>";
        }

        if (!is_numeric($_POST['cvv_num'])) {
            $invalid = true;
            echo "CVV must only contain numbers.<br>";
        }

        if (strlen($_POST['credit_card_num']) < 13 || strlen($_POST['credit_card_num']) > 19) {
            $invalid = true;
            echo "Credit card number must be between 13 and 19 digits.<br>";
        }

        if (strlen($_POST['cvv_num']) < 3 || strlen($_POST['cvv_num']) > 4) {
            $invalid = true;
            echo "CVV must be 3 or 4 digits.<br>";
        }

        if (strlen(trim($_POST['shipping_address'])) > 64) {
            $invalid = true;
            echo "Shipping address is too long.<br>";
        }

        if (strlen(trim($_POST['billing_address'])) > 64) {
            $invalid = true;
            echo "Billing address is too long.<br>";
        }

        if (isset($_POST['order_note']) && strlen(trim($_POST['order_note'])) > 256) {
            $invalid = true;
            echo "Order note is too long.<br>";
        }

        // only submit order if required fields exist
        if (!$missing && !$invalid) {

            // get payment form values
            $contact_email = $_POST['contact_email'];
            $shipping_address = $_POST['shipping_address'];
            $billing_address = $_POST['billing_address'];
            $credit_card_num = $_POST['credit_card_num'];
            $cvv_num = $_POST['cvv_num'];
            $order_note = $_POST['order_note'];

            // create order
            $pdo->prepare("
                INSERT INTO Orders
                (CUSTOMER_ID, ORDER_STATUS, CONTACT_EMAIL, SHIPPING_ADDRESS, BILLING_ADDRESS, CREDIT_CARD_NUM, CVV_NUM, ORDER_NOTE)
                VALUES
                (:u, 'Processing', :e, :s, :b, :c, :v, :n)
            ")->execute([
                ':u' => $useridx,
                ':e' => $contact_email,
                ':s' => $shipping_address,
                ':b' => $billing_address,
                ':c' => $credit_card_num,
                ':v' => $cvv_num,
                ':n' => $order_note
            ]);

            // get new order id
            $order_id = $pdo->lastInsertId();

            // get cart items
            $stmt = $pdo->prepare("
                SELECT PROD_ID, ORDER_QTY
                FROM CartContains
                WHERE CUSTOMER_ID = :u
            ");

            $stmt->execute([':u' => $useridx]);
            $items = $stmt->fetchAll();

            // move cart items to order
            foreach ($items as $item) {

                // add item to ordercontains
                $pdo->prepare("
                    INSERT INTO OrderContains (ORDER_ID, PROD_ID, ORDER_QTY)
                    VALUES (:o, :p, :q)
                ")->execute([
                    ':o' => $order_id,
                    ':p' => $item['PROD_ID'],
                    ':q' => $item['ORDER_QTY']
                ]);

                // subtract bought quantity from inventory
                $pdo->prepare("
                    UPDATE Inventory
                    SET PROD_QTY = PROD_QTY - :q
                    WHERE PROD_ID = :p
                ")->execute([
                    ':q' => $item['ORDER_QTY'],
                    ':p' => $item['PROD_ID']
                ]);
            }

            // clear user's cart
            $pdo->prepare("
                DELETE FROM CartContains
                WHERE CUSTOMER_ID = :u
            ")->execute([
                ':u' => $useridx
            ]);

            // reset checkout state
            $_SESSION['checkout'] = false;

            $success = true;

        } else {

            if ($missing) {
                echo "Missing required payment info.";
            }

        }

    }
?>

<html>
    <head>
        <title>Payment</title>
        <link rel="stylesheet" href="styles.css">
    </head>

    <body class="page">
        
        <h1 class="title">Payment Info</h1>

        <?php if ($success): ?>
            <div class="login-form">
                <h1 class="title">Your cart is officially an order!</h1>
                <br>
                <a class="submit-btn" href="home_page.php">Continue</a>
            </div>
        <?php else: ?>

            <!-- all the inputs -->
            <form method="post" class="login-form">
                Email <br>
                <input class="input-field" name="contact_email" 
                value="<?php echo htmlspecialchars($_POST['contact_email'] ?? ''); ?>"><br>

                Shipping Address<br>
                <input class="input-field" name="shipping_address" 
                value="<?php echo htmlspecialchars($_POST['shipping_address'] ?? ''); ?>"><br>

                Billing Address<br>
                <input class="input-field" name="billing_address" 
                value="<?php echo htmlspecialchars($_POST['billing_address'] ?? ''); ?>"><br>

                Credit Card Number<br>
                <input class="input-field" name="credit_card_num" 
                value="<?php echo htmlspecialchars($_POST['credit_card_num'] ?? ''); ?>"><br>

                Security Code<br>
                <input class="input-field" name="cvv_num" 
                value="<?php echo htmlspecialchars($_POST['cvv_num'] ?? ''); ?>"><br>

                Order Note<br>
                <input class="input-field" name="order_note" 
                value="<?php echo htmlspecialchars($_POST['order_note'] ?? ''); ?>"><br>

                <button class="submit-btn" type="submit" name="submit_order">Submit</button>
                <button class="submit-btn" type="submit" name="cancel">Cancel</button>
            </form>

        <?php endif; ?>

    </body>

</html>