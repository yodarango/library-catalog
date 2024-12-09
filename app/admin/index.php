<?php
include_once('snippets/admin_header.php');

// Establish database connection
$db = new Database(array(
      'type' => 'mysql',
      'host' => $hostname,
      'database' => $database,
      'user' => $username,
      'password' => $password
));

// Connessione al database
$collection = $db->table('prayer_requests');

// Ottieni tutti i dati dalla tabella prayer_requests
$prayerRequests = $collection->select('*')->where("is_archived = 0")->order('created_at DESC')->all();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
      $id = $_POST['id'];

      if ($collection) {
            if (is_numeric($id)) {
                  $updated = $collection->where("id", "=", $id)->limit(1)->update(['is_archived' => 1]);

                  header("Location: " . $_SERVER['PHP_SELF']);
            } else {
                  echo "Errore: Impossibile accedere alla tabella 'prayer_requests'.";
            }
      }
}

?>

<h2 class="mb-4">Prayer requests <?= count($prayerRequests) ?></h2>
<?php foreach ($prayerRequests as $request): ?>
      <div class="p-4 bg-gamma rounded mb-4">
            <h3 class="mb-2"><?= $request->name ?></h3>
            <p class="mb-2"><?= $request->description ?></p>
            <p class="color-lambda mb-2"><?= $request->email ?></p>
            <i class="opacity-70 mb-4 d-block"><?= date("m/d/Y H:i", strtotime($request->created_at)) ?></i>
            <form action="/admin" method="POST" class="w-100">
                  <input type="hidden" name="id" value="<?= htmlspecialchars($request->id) ?>">
                  <button type="submit" class="bg-warning rounded color-beta w-100">Archive </button>
            </form>
      </div>
<?php endforeach; ?>

<?php include_once('snippets/admin_footer.php'); ?>