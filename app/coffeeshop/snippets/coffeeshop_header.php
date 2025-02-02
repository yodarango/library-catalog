<?php
ob_start();
session_start();

include_once('app/snippets/logged-in.php');

$path = $_SERVER['REQUEST_URI'];
// including Kirby Toolkit
require_once('./toolkit/bootstrap.php');
// including Database Connection
require_once('./config/connect.php');
if (file_exists('./config/configure.php')) {
      unlink('./config/configure.php');
      include_once('update-status.php');
}

// initializing the database connection so all pages have access to it 
$db = new Database(array(
      'type' => 'mysql',
      'host' => $hostname,
      'database' => $database,
      'user' => $username,
      'password' => $password
));


// get the orders for this user
$orders = [];

if (isset($_SESSION['username'])) {;
      $table = $db->table('orders');
      $orders = $table
            ->select('*')
            ->where('order_by', '=', $_SESSION['username'])
            ->where('is_fulfilled', '=', 0)
            ->all();
} else {
      // set a random id in the session for the guest user
      if (!isset($_SESSION['guest_id'])) {
            $_SESSION['is_guest'] = true;
            $_SESSION['username'] = 'guest' . uniqid();
      }
}
// add the total price of the orders

$total = 0;
foreach ($orders as $order) {
      $total += $order->item_price;
}

// add a decimal point to the total
$total = number_format(($total / 100), 2);


// remove an order
if (isset($_GET['remove_order'])) {
      $orderIdToRemove = $_GET['remove_order'];
      try {
            $table->where('id', '=', $orderIdToRemove)->delete();
            header('Location: /coffeeshop');
            echo '<div class="alert bg-success mb-4 p-4 color-beta">Order removed</div>';
      } catch (Exception $e) {
            echo '<div class="alert bg-danger mb-4 p-4 color-alpha">Failed to remove order</div>';
      }
}
?>
<!DOCTYPE HTML>
<html lang="en">

<head>
      <meta charset="ISO-8859-2">
      <meta name="viewport" content="width=device-width,initial-scale=1.0">

      <meta name="description" content="Personal book catalog">
      <meta name="keywords" content="book, catalog">

      <!-- <link href="./assets/icons/favicon.png" rel="shortcut icon"
            type="image/png" />
      <link href="./assets/icons/apple-touch-icon.png" rel="apple-touch-icon" />
      <link href="./assets/icons/apple-touch-icon-152x152.png" rel="apple-touch-icon" sizes="152x152" />
      <link href="./assets/icons/apple-touch-icon-167x167.png" rel="apple-touch-icon" sizes="167x167" />
      <link href="./assets/icons/apple-touch-icon-180x180.png" rel="apple-touch-icon" sizes="180x180" /> -->
      <link href="./assets/icons/logo.webp" rel="icon" sizes="128x128" />

      <link rel="stylesheet" type="text/css" href="https://cdn.danielrangel.net/fullds.min.css">
      <!-- TODO: sostituie questo con i miei iconi -->
      <link rel="stylesheet" href="assets/css/font-awesome.min.css">
      <link rel="stylesheet" href="assets/css/app.css">
      <title>Coffeeshop</title>
</head>

<body>
      <main class="main" role="main">
            <!-- drawer opens from the right -->
            <div>
                  <div id="order-drawer" class="drawer drawer--right">
                        <button class="btn bg-nu color-alpha drawer__close" onclick="closeOrderDrawer()">
                              <i class="fa fa-times color-alpha"></i>
                        </button>
                        <div class="drawer__content">
                              <div class="d-flex align-items-center justify-content-between w-100">
                                    <h3 class="drawer__title">Your Orders</h3>
                                    <a target="_blank" href="https://giv.li/ksmjn7">
                                          <div class="btn py-2 px-4 bg-warning" onclick="openOrderDrawer()">
                                                <i class="fa fa-shopping-bag color-beta"></i>
                                                <span class="color-beta">Pay $<?= $total ?></span>
                                          </div>
                                    </a>
                              </div>
                              <ul class="order-list">
                                    <?php foreach ($orders as $order): ?>
                                          <li class="order-item border-bottom border-zeta py-6">
                                                <a href="?remove_order=<?= $order->id ?>">
                                                      <i class="fa fa-trash color-danger"></i>
                                                </a>
                                                <span class="order-name"><?= htmlspecialchars($order->item_name) ?></span>
                                                <span class="order-price">$<?= number_format(($order->item_price / 100), 2) ?></span>

                                          </li>
                                    <?php endforeach; ?>
                              </ul>
                        </div>
                  </div>
            </div>
            <script>
                  function openOrderDrawer() {
                        document.getElementById("order-drawer").classList.add("drawer--open");
                  }

                  function closeOrderDrawer() {
                        document.getElementById("order-drawer").classList.remove("drawer--open");
                  }
            </script>

            <!-- header -->
            <header class="app-header d-flex align-items-center justify-content-start bg-delta">
                  <div class="d-flex align-items-center justify-content-between w-100 column-gap-4">
                        <div class="app-header-label d-flex align-items-center justify-content-start w-100 column-gap-4">
                              <a class=" coffeeshop-logo flex-shrink-0" href="index">
                                    <img src="assets/icons/logo.webp" alt="coffeeshop icon ">
                              </a>
                              <h2 class="text-center">Coffee Shop</h2>
                        </div>

                        <!-- cart -->
                        <div class="header-icon">
                              <?php if (count($orders) > 0) { ?>
                                    <button class="icon-badge" onclick="openOrderDrawer()">
                                          <i class="fa fa-shopping-bag color-beta"></i>
                                          <span class="color-beta">Pay $<?= $total ?></span>
                                    </button>
                              <?php } else { ?>
                                    <i class="fa fa-shopping-bag color-alpha"></i>
                              <?php } ?>
                        </div>
                  </div>
            </header>
            <section class="main-content-area bg-beta">
                  <div>