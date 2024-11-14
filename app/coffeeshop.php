<?php
include_once('config/config.php');
include_once('toolkit/bootstrap.php');

// Connessione al database
$db = new Database(array(
      'type' => 'mysql',
      'host' => $hostname,
      'database' => $database,
      'user' => $username,
      'password' => $password
));

// Recupera i dati dalla tabella coffees
$collection = $db->table('coffees');
$coffees = $collection->select('*')->order('name ASC')->all();
?>

<!DOCTYPE html>
<html lang="it">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>STWC | Coffee Shop</title>
      <style>
            .card {
                  border: 1px solid #ddd;
                  border-radius: 8px;
                  padding: 16px;
                  margin: 16px;
                  max-width: 300px;
                  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                  text-align: center;
            }

            .card img {
                  width: 100%;
                  height: auto;
                  border-radius: 4px;
                  margin-bottom: 12px;
            }

            .card h3 {
                  margin-top: 0;
                  font-size: 1.5em;
            }

            .card p {
                  margin: 8px 0;
            }

            .price {
                  font-weight: bold;
                  color: #2c3e50;
            }

            .card-container {
                  display: flex;
                  flex-wrap: wrap;
                  justify-content: space-around;
            }
      </style>
</head>

<body>

      <h2>The Coffee Shop</h2>

      <div class="card-container">
            <?php foreach ($coffees as $coffee): ?>
                  <div class="card">
                        <?php if (!empty($coffee->thumbnail)): ?>
                              <img src="<?= htmlspecialchars($coffee->thumbnail) ?>" alt="<?= htmlspecialchars($coffee->name) ?>">
                        <?php else: ?>
                              <img src="default-thumbnail.jpg" alt="Immagine predefinita">
                        <?php endif; ?>
                        <h3><?= htmlspecialchars($coffee->name) ?></h3>
                        <p class="price">€<?= number_format($coffee->price, 2) ?></p>
                        <p><?= htmlspecialchars($coffee->description) ?></p>
                  </div>
            <?php endforeach; ?>
      </div>

</body>

</html>