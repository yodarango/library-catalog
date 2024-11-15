<?php

$collection = $db->table('books');

$collection->where('id', '=', $_POST["id"])->update(['lentto' => $_SESSION['user_id'], 'lentat' => date('Y-m-d'), 'islent' => 1]);

if ($collection->error()) {
      echo "Error: " . $collection->error();
      exit();
} else {
}
