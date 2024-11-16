<?php
ob_start();
include_once('snippets/library_header.php');

if (isset($_POST["id"])) {
      $collection = $db->table('books');

      $collection->where('id', '=', $_POST["id"])->update(['lentto' => $_SESSION['username'], 'lentat' => date('Y-m-d'), 'islent' => $_POST["is_lent"]]);

      // redirect to the book page
      header('Location: /book?id=' . $_POST["id"]);
}
ob_end_flush();
