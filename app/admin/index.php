<?php
include_once('config/config.php');
include_once('toolkit/bootstrap.php');

// Establish database connection
$db = new Database(array(
      'type' => 'mysql',
      'host' => $hostname,
      'database' => $database,
      'user' => $username,
      'password' => $password
));

// TODO: FIX THIS SO THE REQUEST MAY BE ARCHIVED
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//       $id = $_POST['id'];

//       // Connessione al database
//       $collection = $db->table('prayer_requests');

//       // Verifica che la connessione sia riuscita
//       if ($collection) {
//             // Aggiorna il campo is_archived a 1 per l'id specificata
//             if (is_numeric($id)) {
//                   $updated = $collection->where("id", $id)->limit(1)->update(['is_archived' => 1]);
//             }
//             // Reindirizza alla stessa pagina per evitare il re-invio del form
//             header("Location: " . $_SERVER['PHP_SELF']);
//             exit();
//       } else {
//             echo "Errore: Impossibile accedere alla tabella 'prayer_requests'.";
//       }
// }

// Connessione al database
$collection = $db->table('prayer_requests');

// Ottieni tutti i dati dalla tabella prayer_requests
$prayerRequests = $collection->select('*')->where("is_archived = 0")->order('created_at DESC')->all();

?>

<!DOCTYPE html>
<html lang="it">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Prayer Requests</title>
      <style>
            table {
                  width: 100%;
                  border-collapse: collapse;
            }

            table,
            th,
            td {
                  border: 1px solid black;
            }

            th,
            td {
                  padding: 8px;
                  text-align: left;
            }

            th {
                  background-color: #f2f2f2;
            }
      </style>
</head>

<body>

      <h2>Prayer Requests</h2>

      <table>
            <tr>
                  <th>ID</th>
                  <th>Nome</th>
                  <th>Email</th>
                  <th>Telefono</th>
                  <th>Descrizione</th>
                  <th>Data di Creazione</th>
                  <th>Azioni</th>
            </tr>
            <?php foreach ($prayerRequests as $request): ?>
                  <tr>
                        <td><?= htmlspecialchars($request->id) ?></td>
                        <td><?= htmlspecialchars($request->name) ?></td>
                        <td><?= htmlspecialchars($request->email) ?></td>
                        <td><?= htmlspecialchars($request->phone) ?></td>
                        <td><?= htmlspecialchars($request->description) ?></td>
                        <td><?= date("m/d/Y H:i", strtotime(htmlspecialchars($request->created_at))) ?></td>
                        <td>
                              <form action="/admin" method="POST">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($request->id) ?>">
                                    <button type="submit">Archivia</button>
                              </form>
                        </td>
                  </tr>
            <?php endforeach; ?>
      </table>

</body>

</html>