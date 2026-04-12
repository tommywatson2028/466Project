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
                <h1> Order Fulfillment </h1>
        </body>
</html>

