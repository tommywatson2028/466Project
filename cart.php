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

session_start();
include 'set_connection_params.php';

// try and connect
try {

    $pdo = new PDO($dsn, $username, $password);

} catch(PDOException $e) {

    echo "Connection to database failed: " . $e->getMessage();

}

if (!isset($_POST['next'])) {
    $_SESSION['checkout'] = false;
}

// current user
$useridx = "Junkie";
// $_SESSION['useridx'];

// handle post
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // check action
    if (isset($_POST['action'])) {
        $prod_id = $_POST['prod_id'];

        // check quantities
        $stmt = $pdo->prepare(
            "SELECT CartContains.ORDER_QTY, Inventory.PROD_QTY
            FROM CartContains
            JOIN Inventory ON CartContains.PROD_ID = Inventory.PROD_ID
            WHERE CartContains.CUSTOMER_ID = :u AND CartContains.PROD_ID = :p"
        );

        // run select
        $stmt->execute([
            ':u' => $useridx, 
            ':p' => $prod_id
        ]);

        // fetch row
        $row = $stmt->fetch();

        // check row
        if ($row) {

            // add item
            if ($_POST['action'] == 'plus' && $row['ORDER_QTY'] < $row['PROD_QTY']) {

                // update cart
                $pdo->prepare(
                    "UPDATE CartContains
                    SET ORDER_QTY = ORDER_QTY + 1
                    WHERE CUSTOMER_ID = :u AND PROD_ID = :p"
                )->execute([
                    ':u' => $useridx,
                    ':p' => $prod_id
                ]);
            }

            // remove item
            if ($_POST['action'] == 'minus') {

                // lower qty
                if ($row['ORDER_QTY'] > 1) {

                    // update cart
                    $pdo->prepare(
                        "UPDATE CartContains
                        SET ORDER_QTY = ORDER_QTY - 1
                        WHERE CUSTOMER_ID = :u AND PROD_ID = :p"
                    )->execute([
                        ':u' => $useridx,
                        ':p' => $prod_id
                    ]);

                } else {

                    // delete item
                    $pdo->prepare(
                        "DELETE FROM CartContains
                        WHERE CUSTOMER_ID = :u AND PROD_ID = :p"
                    )->execute([
                        ':u' => $useridx,
                        ':p' => $prod_id
                    ]);

                }
            }
        }
    }

    // show form and double check for anything in the cart.
    if (isset($_POST['next'])) {

        // check cart
        $stmt = $pdo->prepare("
            SELECT *
            FROM CartContains
            WHERE CUSTOMER_ID = :u
        ");
        $stmt->execute([':u' => $useridx]);
        $row = $stmt->fetch();

        // show checkout
        if ($row) {
            $_SESSION['checkout'] = true;
        } else {
            echo "Cart is empty";
        }
    }

    // hide form
    if (isset($_POST['cancel'])) {
        $_SESSION['checkout'] = false;
    }

    // check submit
    if (isset($_POST['submit_order'])) {


        // needed info
        $required = [
            'contact_email',
            'shipping_address',
            'billing_address',
            'credit_card_num',
            'cvv_num'
        ];

        $missing = false;

        foreach ($required as $field) {
            if (!isset($_POST[$field]) || trim($_POST[$field]) == "") {
                $missing = true;
            }
        }

        // if the info is there then we good.
        if (!$missing) {

            $contact_email = $_POST['contact_email'];
            $shipping_address = $_POST['shipping_address'];
            $billing_address = $_POST['billing_address'];
            $credit_card_num = $_POST['credit_card_num'];
            $cvv_num = $_POST['cvv_num'];
            $order_note = $_POST['order_note'];

            // push order
            $pdo->prepare("
                INSERT INTO Orders
                (CUSTOMER_ID, ORDER_STATUS, CONTACT_EMAIL, SHIPPING_ADDRESS, BILLING_ADDRESS, CREDIT_CARD_NUM, CVV_NUM, ORDER_NOTE)
                VALUES
                (:u, 'PROCESSING', :e, :s, :b, :c, :v, :n)
            ")->execute([
                ':u' => $useridx,
                ':e' => $contact_email,
                ':s' => $shipping_address,
                ':b' => $billing_address,
                ':c' => $credit_card_num,
                ':v' => $cvv_num,
                ':n' => $order_note
            ]);

            // get order id
            $order_id = $pdo->lastInsertId();

            // get cart rows
            $stmt = $pdo->prepare("
                SELECT PROD_ID, ORDER_QTY
                FROM CartContains
                WHERE CUSTOMER_ID = :u
            ");

            // run select
            $stmt->execute([':u' => $useridx]);

            // fetch items
            $items = $stmt->fetchAll();

            // loop items
            foreach ($items as $item) {

                // push items
                $pdo->prepare("
                    INSERT INTO OrderContains (ORDER_ID, PROD_ID, ORDER_QTY)
                    VALUES (:o, :p, :q)
                ")->execute([
                    ':o' => $order_id,
                    ':p' => $item['PROD_ID'],
                    ':q' => $item['ORDER_QTY']
                ]);

                // update stock
                $pdo->prepare("
                    UPDATE Inventory
                    SET PROD_QTY = PROD_QTY - :q
                    WHERE PROD_ID = :p
                ")->execute([
                    ':q' => $item['ORDER_QTY'],
                    ':p' => $item['PROD_ID']
                ]);
            }

            // clear cart
            $pdo->prepare("
                DELETE FROM CartContains
                WHERE CUSTOMER_ID = :u
            ")->execute([
                ':u' => $useridx
            ]);

            // hide checkout
            $_SESSION['checkout'] = false;

            echo 'Your cart is officially an order!';
        }
    }
}

// get cart
$stmt = $pdo->prepare("
    SELECT CartContains.PROD_ID, CartContains.ORDER_QTY, Inventory.PROD_NAME, Inventory.PRICE
    FROM CartContains
    JOIN Inventory ON CartContains.PROD_ID = Inventory.PROD_ID
    WHERE CartContains.CUSTOMER_ID = :u
");

// run select
$stmt->execute([':u' => $useridx]);

// fetch cart
$items = $stmt->fetchAll();

?>


<html>
<head>
    <title>Cart</title>
</head>
<body>

<h1>Cart</h1>

<div>
    <?php foreach ($items as $item): ?>
    <!-- loop through items -->
        <div>
            Item : <?php echo $item['PROD_NAME']; ?>,
            Qty : <?php echo $item['ORDER_QTY']; ?>,
            Price : $<?php echo $item['PRICE'] * $item['ORDER_QTY']; ?>

            <form method="post" style="display:inline;">
                <input type="hidden" name="prod_id" value="<?php echo $item['PROD_ID']; ?>">
                <button name="action" value="plus">+</button>
            </form>

            <form method="post" style="display:inline;">
                <input type="hidden" name="prod_id" value="<?php echo $item['PROD_ID']; ?>">
                <button name="action" value="minus">-</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>

<div>
    <form method="post">
        <button name="next">Next</button>
    </form>
</div>

<div>
    <?php if (!empty($_SESSION['checkout'])): ?>
        <form method="post">
            CONTACT_EMAIL <input name="contact_email"><br>
            SHIPPING_ADDRESS <input name="shipping_address"><br>
            BILLING_ADDRESS <input name="billing_address"><br>
            CREDIT_CARD_NUM <input name="credit_card_num"><br>
            CVV_NUM <input name="cvv_num"><br>
            ORDER_NOTE <input name="order_note"><br>

            <button type="submit" name="submit_order">Submit</button>
            <button type="submit" name="cancel">Cancel</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>