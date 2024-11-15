<?php include_once('snippets/library_header.php') ?>
<link rel="stylesheet" href="assets/css/book.css">

<?php
$collection = $db->table('books');

$url = $_SERVER['REQUEST_URI'];
$id = parse_url($url, PHP_URL_QUERY);
if (strpos($id, 'id=') !== FALSE) {
	$bookid = str_replace('id=', '', $id);

	$item = $collection->find($bookid);
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
			<a class="borrow-boo p-2 bg-zeta color-alpha rounded d-block w-100" href="/borrow<?php echo $id; ?>"><i class="fa fa-trash me-2" aria-hidden="true"></i><span>Borrow</span></a>
			<?php
			include_once('app/snippets/logged-in.php');
			if (is_admin() == true) { ?>
				<div class="book-actions mt-6 d-flex align-items-center justify-content-center gap-4">
					<a class="item-action delete p-2 bg-danger color-alpha rounded d-block w-100 flex-shrink-1" href="delete?<?php echo $id; ?>"><i class="fa fa-trash me-2" aria-hidden="true"></i><span>Delete</span></a>
					<a class="item-action edit p-2 bg-info color-beta rounded d-block w-100 flex-shrink-1" href="edit?<?php echo $id; ?>"><i class="fa fa-pencil-square-o me-2" aria-hidden="true"></i><span>Edit</span></a>
				</div>

			<?php } ?>
		</div>
	</div>

	<p class="book-description"><i class="fa-comment fa me-2 d-inline-block"></i> <span><?php echo $item->description(); ?></span></p>

<?php } ?>