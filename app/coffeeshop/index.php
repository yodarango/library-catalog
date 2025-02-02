<?php
include_once('snippets/coffeeshop_header.php');

// Recupera i dati dalla tabella coffees
$collection = $db->table('coffees');
$coffees = $collection->select('*')->order('name ASC')->all();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $coffee_id = $_POST['id'];
      $coffee_name = $_POST['name'];
      $coffee_price = $_POST['price'];
      $user = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';

      // inserisci l'ordine nella tabella orders
      $collection = $db->table('orders');
      $affectedRows = $collection->insert(array(
            'item_id' => $coffee_id,
            'item_name' => $coffee_name,
            'item_price' => $coffee_price,
            'order_by' => $user,
            'is_fulfilled' => 0
      ));

      if ($affectedRows > 0) {
            // reload
            header('Location: coffeeshop');
      } else {
            echo '<div class="alert bg-danger mb-4 p-4 color-alpha">Order failed</div>';
      }
}
?>

<div class="coffee-card-container bg-beta">
      <?php foreach ($coffees as $coffee): ?>

            <div class="coffee-card p-4 border rounded d-flex align-items-center justify-content-start gap-4 mb-4">
                  <?php if (!empty($coffee->thumbnail)): ?>
                        <img class="rounded" src="<?= htmlspecialchars($coffee->thumbnail) ?>" alt="<?= htmlspecialchars($coffee->name) ?>">
                  <?php else: ?>
                        <img class="rounded" src="assets/images/cappuccino.webp" alt="Immagine predefinita">
                  <?php endif; ?>
                  <div>
                        <h4 class="mb-2"><?= htmlspecialchars($coffee->name) ?></h4>
                        <p class="mb-2 description"><?= htmlspecialchars($coffee->description) ?></p>
                        <div class="d-flex align-items-center justify-content-start gap-4">

                              <button class="p-2 color-alpha opacity-70 bg-nu d-flex align-items-center justify-content-start gap-2">
                                    <i class="fa fa-dollar"></i>
                                    <spa><?= number_format(($coffee->price / 100), 2) ?></spa>
                              </button>

                              <form method="post" action="">
                                    <input type="hidden" name="id" value="<?= $coffee->id ?>">
                                    <input type="hidden" name="name" value="<?= $coffee->name ?>">
                                    <input type="hidden" name="price" value="<?= $coffee->price ?>">
                                    <button type="submit" class="p-2 color-beta bg-epsilon d-flex align-items-center justify-content-start gap-2">
                                          <i class="fa fa-shopping-bag"></i>
                                          <span>Order this</span>
                                    </button>
                              </form>
                        </div>
                  </div>
            </div>

      <?php endforeach; ?>
</div>
<?php include_once('app/snippets/app_footer.php') ?>