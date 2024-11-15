<?php include_once('snippets/library_header.php') ?>
<link rel="stylesheet" href="assets/css/book.css">

<?php
$collection = $db->table('books');

$url = $_SERVER['REQUEST_URI'];
$id = parse_url($url, PHP_URL_QUERY);
$bookid = null;

// Verifica se l'URL contiene 'id=' o 'borrow-id='
parse_str($id, $queryParams);
if (isset($queryParams['id'])) {
	$bookid = $queryParams['id'];
}

if ($bookid !== null) {
	$item = $collection->find($bookid);
}

if (isset($item)) {

	// button label and class
	$borrow_button_label = "Borrow";
	$button_class = "bg-epsilon";
	$is_disabled = false;

	if ($item->islent() && $item->lentto() == get_username()) {
		$borrow_button_label = "Return";
		$button_class = "bg-zeta";
	} else if ($item->islent()) {
		$borrow_button_label = "Unavailable";
		$button_class = "bg-pi";
		$is_disabled = true;
	} else if ($item->islent() && $item->lentto() != get_username()) {
		$borrow_button_label = "Borrowed by " . $item->lentto();
		$button_class = "bg-upsilon color-beta";
		$is_disabled = true;
	}

	// button class


?>


	<div class="book-detail-container gap-4">
		<div class="book-detail-image d-flex align-items-center justify-content-center">
			<img src="<?php echo $item->imgpath(); ?>" alt="<?php echo $item->title(); ?>">
		</div>
		<div class="book-detail-info bg-gamma p-4 mb-4 rounded">
			<h3 class="color-alpha mb-2"><?php echo $item->title(); ?></h3>
			<p class="book-author color-zeta"><i class="fa-user fa me-2 d-inline-block color-zeta"></i> <span><?php echo $item->author(); ?></span></p>
			<p class="book-year color-zeta"><i class="fa-calendar fa me-2 d-inline-block color-zeta"></i> <span><?php echo $item->year(); ?></span></p>
			<p class="book-description color-zeta"><i class="color-zeta fa-building fa me-2 d-inline-block"></i> <span><?php echo $item->publisher(); ?></span></p>
			<p class="book-description color-zeta mb-2"><i class="color-zeta fa-tags fa me-2 d-inline-block"></i> <span><?php echo $item->genre(); ?></span></p>
			<!-- if this is an admin they should be able to delete and edit  -->
			<?php if (logged_in()) { ?>
				<form method="POST" action="/borrow">
					<input type="hidden" name="id" value="<?php echo $bookid; ?>">
					<input type="hidden" name="is_lent" value="<?php echo $item->islent() ? "0" : "1"; ?>">
					<button type="submit" class="borrow-book p-2 <?php echo $button_class ?> color-alpha rounded d-block w-100" <?php echo $is_disabled ? "disabled" : "" ?>>
						<i class="fa fa-exchange me-2" aria-hidden="true"></i>
						<span><?php echo $borrow_button_label; ?></span>
					</button>
				</form>
			<?php } ?>
			<?php
			include_once('app/snippets/logged-in.php');
			if (is_admin() == true) { ?>
				<div class="book-actions mt-2 d-flex align-items-center justify-content-center gap-2">
					<a class="item-action delete p-2 bg-danger color-alpha rounded d-block w-100 flex-shrink-1" href="delete?<?php echo $bookid; ?>"><i class="fa fa-trash me-2" aria-hidden="true"></i><span>Delete</span></a>
					<a class="item-action edit p-2 bg-info color-beta rounded d-block w-100 flex-shrink-1" href="edit?<?php echo $bookid ?>"><i class="fa fa-pencil-square-o me-2" aria-hidden="true"></i><span>Edit</span></a>
				</div>

			<?php } ?>
		</div>
	</div>

	<p class="book-description"><i class="fa-comment fa me-2 d-inline-block"></i> <span><?php echo $item->description(); ?></span></p>

<?php
}
?>
<?php include_once('snippets/library_footer.php') ?>