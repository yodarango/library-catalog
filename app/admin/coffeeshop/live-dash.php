<?php
include_once('app/admin/snippets/admin_header.php'); ?>

<?php


// Gestione dell'aggiornamento di is_fulfilled
if (isset($_POST['fulfill_order'])) {
      $orderId = $_POST['fulfill_order'];
      $db->table('orders')->where('id', '=', $orderId)->update(array('is_fulfilled' => 1));
}

// Recupero degli ordini
$orders = $db->table('orders')->select('*')->where("is_fulfilled", "=", 0)->order("created_date desc")->all();
?>

<main>
      <!-- back -->
      <div class="d-flex align-items-center justify-content-start mb-4">
            <i class="fa fa-arrow-left color-epsilon me-2" aria-hidden="true"></i>
            <a href="/admin-coffeeshop" class="color-epsilon">Back</a>
      </div>
      <?php if (count($orders) == 0) { ?>
            <div role="alert" class="bg-info rounded p-4 color-">
                  <p class="color-beta">There are no orders at this time!</p>
            </div>
      <?php } else { ?>

            <section class="mt-8 mb-4">
                  <h3 class="mb-4">Orders</h3>
                  <table class="table">
                        <thead>
                              <tr>
                                    <th>Item</th>
                                    <th>Item</th>
                                    <th>Order By</th>
                                    <th>Placed At</th>
                                    <th>Done</th>
                              </tr>
                        </thead>
                        <tbody>
                              <?php foreach ($orders as $order): ?>
                                    <tr>
                                          <td><?= htmlspecialchars($order->item_name) ?></td>
                                          <td>$<?= number_format(($order->item_price / 100), 2) ?></td>
                                          <td><?= htmlspecialchars($order->order_by) ?></td>
                                          <td><?= date('h:i A', strtotime($order->created_date)) ?></td>
                                          <td>
                                                <?php if (!$order->is_fulfilled): ?>
                                                      <form method="post" action="/admin-coffeeshop-live-dash">
                                                            <input type="hidden" name="fulfill_order" value="<?= $order->id ?>">
                                                            <button type="submit" class="btn px-2 py-1 bg-epsilon color-beta">
                                                                  <i class="fa fa-check"></i>
                                                            </button>
                                                      </form>
                                                <?php endif; ?>
                                          </td>
                                    </tr>
                              <?php endforeach; ?>
                        </tbody>
                  </table>
            </section>
      <?php } ?>
</main>

<script>
      function refreshOrders() {
            fetch(window.location.href)
                  .then(response => response.text())
                  .then(html => {
                        const newTable = new DOMParser().parseFromString(html, 'text/html').querySelector('table');
                        if (newTable) {
                              document.querySelector('table').replaceWith(newTable);
                        }
                  });
      }

      setInterval(refreshOrders, 5000);
</script>

<?php include_once('app/snippets/app_footer.php'); ?>