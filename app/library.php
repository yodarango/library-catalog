<?php
include_once('snippets/library_header.php');

$term = $_POST ? $_POST['term'] : "";

$collection = $db->table('books');

$books = [];


// filter the books if it is a post request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $books = $db->table('books')
        ->where('title', 'like', '%' . $term . '%')
        ->orWhere('description', 'like', '%' . $term . '%')
        ->orWhere('publisher', 'like', '%' . $term . '%')
        ->orWhere('isbn', 'like', '%' . $term . '%')
        ->orWhere('year', 'like', '%' . $term . '%')
        ->orWhere('a_str', 'like', '%' . $term . '%')
        ->orWhere('g_str', 'like', '%' . $term . '%')
        ->orWhere('location', 'like', '%' . $term . '%')
        ->orWhere('lentto', 'like', '%' . $term . '%')
        ->orWhere('lentat', 'like', '%' . $term . '%')
        ->all();
} else {
    // or fetch if not filtering
    $books = $collection
        ->select(['id', 'title', 'year', 'author', 'imgpath'])
        ->order('title', 'ASC')
        ->all();
}

?>

<h3 class="mb-4">Browse all <?php echo $books->count() ?> books</h3>
<div class="item-list">

    <script>
        console.log("<?php echo $term ?>")
    </script>
    <?php foreach ($books as $book): ?>
        <!-- <?php var_dump($book); ?> -->
        <a href="book?id=<?php echo $book->id() ?>">
            <div class="book-card">
                <div class="book-card-image">
                    <img src="<?php echo $book->imgpath() ?>" alt="<?php echo $book->title() ?>">
                </div>
                <div class="book-card-info p-2 bg-gamma">
                    <h5 class="color-alpha mb-1 text-center">
                        <?php echo $book->title(); ?>
                    </h5>
                    <p class="color-alpha p-0 color-zeta fs-6 text-center">
                        <?php echo $book->author(); ?>
                    </p>
                </div>
            </div>
        </a>
    <?php endforeach; ?>
</div>
<?php include_once('snippets/library_footer.php') ?>