<?php
include_once('snippets/coffeeshop_header.php');

// Recupera i dati dalla tabella coffees
$collection = $db->table('coffees');
$coffees = $collection->select('*')->order('name ASC')->all();
?>

<div class="coffee-card-container bg-beta">
      <?php foreach ($coffees as $coffee): ?>
            <div class="coffee-card p-4 shadow rounded d-flex align-items-center justify-content-start gap-4 mb-4">
                  <?php if (!empty($coffee->thumbnail)): ?>
                        <img class="rounded" src="<?= htmlspecialchars($coffee->thumbnail) ?>" alt="<?= htmlspecialchars($coffee->name) ?>">
                  <?php else: ?>
                        <img class="rounded" src="assets/images/cappuccino.webp" alt="Immagine predefinita">
                  <?php endif; ?>
                  <div>
                        <h4 class="mb-2"><?= htmlspecialchars($coffee->name) ?></h4>
                        <p class="mb-2 description"><?= htmlspecialchars($coffee->description) ?></p>
                        <button class="p-2 color-alpha bg-lambda d-flex align-items-center justify-content-start gap-2">
                              <i class="fa fa-dollar"></i>
                              <spa><?= number_format($coffee->price, 2) ?></spa>
                        </button>

                  </div>
            </div>
      <?php endforeach; ?>
</div>

<?php
include_once('snippets/app_footer.php');
?>
<?php
include_once('app/snippets/app_footer.php');
?>