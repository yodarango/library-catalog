<?php
session_start();

include_once('logged-in.php');
if (logged_in() == false) {
	redirect_to("login.php");
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
?>
	<!DOCTYPE HTML>
	<html lang="en">

	<head>

		<meta charset="ISO-8859-2">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">

		<title>Library</title>
		<meta name="description" content="Personal book catalog">
		<meta name="keywords" content="book, catalog">

		<link href="./assets/icons/favicon.png" rel="shortcut icon"
			type="image/png" />
		<link href="./assets/icons/apple-touch-icon.png" rel="apple-touch-icon" />
		<link href="./assets/icons/apple-touch-icon-152x152.png" rel="apple-touch-icon" sizes="152x152" />
		<link href="./assets/icons/apple-touch-icon-167x167.png" rel="apple-touch-icon" sizes="167x167" />
		<link href="./assets/icons/apple-touch-icon-180x180.png" rel="apple-touch-icon" sizes="180x180" />
		<link href="./assets/icons/icon-hires.png" rel="icon" sizes="192x192" />
		<link href="./assets/icons/icon-normal.png" rel="icon" sizes="128x128" />

		<link rel="stylesheet" href="assets/css/index_DEL.css">
		<link rel="stylesheet" href="assets/css/font-awesome.min.css">
		<link rel="stylesheet" href="assets/css/library.css">

	</head>

	<?php
	function get_active_class($page)
	{
		$path = $_SERVER['REQUEST_URI'];
		if (strpos($path, $page)) {
			echo 'active';
		}
	}
	?>

	<body>

		<main class="main" role="main">
			<header id="app-header">
				<div id="logo"></div>
				<button id="menu-toggle" class="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i> Menu</button>
				<section id="menu" class="menu-dropdown">
					<ul class="menu-dropdown-list">
						<li class="menu browse <?php get_active_class("index") ?>"><a href="./index"><i class="fa fa-book" aria-hidden="true"></i><span><?php echo $lang['MENU_BROWSE']; ?></span></a></li>
						<li class="menu add <?php get_active_class("add") ?>"><a href="./add"><i class="fa fa-plus" aria-hidden="true"></i><span><?php echo $lang['MENU_ADD']; ?></span></a></li>
						<li class="menu authors <?php get_active_class("authors") ?>"><a href="./authors"><i class="fa fa-users" aria-hidden="true"></i><span><?php echo $lang['MENU_AUTHORS']; ?></span></a></li>
						<li class="menu publishers <?php get_active_class("publishers") ?>"><a href="./publishers"><i class="fa fa-building" aria-hidden="true"></i><span><?php echo $lang['MENU_PUBLISHERS']; ?></span></a></li>
						<li class="menu genres <?php get_active_class("genres") ?>"><a href="./genres"><i class="fa fa-tags" aria-hidden="true"></i><span><?php echo $lang['MENU_GENRES']; ?></span></a></li>
						<li class="menu lent <?php get_active_class("lent") ?>"><a href="./display?lent=on"><i class="fa fa-handshake-o" aria-hidden="true"></i><span><?php echo $lang['MENU_LENT']; ?></span></a></li>
					</ul>
					<div class="clear"></div>
				</section>
			</header>

			<section id="content-area">
				<div id="global-search">
					<form action="search" id="searchform" method="post">
						<input class="searchform" type="text" name="term" required />
						<button class="searchbutton" type="submit"
							value="<?php echo $lang['SEARCHFORM_SUBMIT']; ?>">
							<i class="fa fa-search" aria-hidden="true"></i>
						</button>
					</form>
				</div>
			<?php } ?>

			<script>
				document.getElementById('menu-toggle').addEventListener('click', function() {
					document.getElementById('menu').classList.toggle('show');
				});
			</script>