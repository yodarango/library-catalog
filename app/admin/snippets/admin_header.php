<?php
ob_start();
session_start();

include_once('app/snippets/logged-in.php');
if (logged_in() == false || !is_admin()) {
      redirect_to("login");
} else {
      $path = $_SERVER['REQUEST_URI'];
      // including Kirby Toolkit
      require_once('./toolkit/bootstrap.php');
      // including Database Connection
      require_once('./config/connect.php');
      if (file_exists('./config/configure.php')) {
            unlink('./config/configure.php');
            include_once('update-status.php');
      }
      if (isset($lang)) {
            include_once('./languages/' . $lang . '.php');
      } else {
            include_once('./languages/en-US.php');
      }

      // initializing the database connection so all pages have access to it 
      $db = new Database(array(
            'type' => 'mysql',
            'host' => $hostname,
            'database' => $database,
            'user' => $username,
            'password' => $password
      ));
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
            <link rel="stylesheet" href="assets/css/admin.css">
            <title>Coffeeshop</title>
      </head>

      <body>
            <main class="main" role="main">
                  <!-- header -->
                  <header class="admin-header d-flex align-items-center justify-content-start bg-delta">
                        <div class="d-flex align-items-center justify-content-between w-100 column-gap-4">
                              <a class="logo flex-shrink-0" href="index">
                                    <img src="assets/icons/logo.webp" alt="Library icon ">
                              </a>
                              <?php
                              $term = isset($_POST["term"]) ? $_POST['term'] : "";
                              ?>
                              <?php if ($path == '/admin-library') { ?>
                                    <div class="global-search w-100">
                                          <form action="/admin-library" id="searchform" method="post" class="w-100 d-flex align-items-center justify-content-start column-gap-2">
                                                <input class="search-form p-2 rounded w-100 d-block" type="text" name="term"
                                                      placeholder="Search for a book" value="<?php echo $term ?>" />
                                                <button class="search-button bg-nu p-0" type="submit"
                                                      value="Search collection">
                                                      <i class="fa fa-search" aria-hidden="true"></i>
                                                </button>
                                          </form>
                                    </div>
                              <?php } ?>
                        </div>
                  </header>
                  <section class="main-content-area bg-beta">
                        <div>
                        <?php } ?>