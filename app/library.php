<?php
include_once('snippets/library_header.php');

// Fetch books from the database
$books = $db->table('books')
    ->select('books.id', 'books.title', 'books.year', 'books.cover')
    ->order('title', 'ASC')
    ->all();

?>

<h2>
    <i class="fa fa-book" aria-hidden="true"></i><?php echo $lang['INDEX_TITLE']; ?>
</h2>

<div id="item-list">

    <?php foreach ($books as $book): ?>
        <div class="book-card">
            <div class="book-card-image">
                <a href="display?id=<?php echo $book->id() ?>">
                    <img src="images/<?php echo $book->cover() ?>" alt="<?php echo $book->title() ?>">
                </a>
            </div>
            <div class="book-card-info">
                <h3>
                    <a href="display?id=<?php echo $book->id() ?>"><?php echo $book->title() ?></a>
                </h3>
                <p>
                    <?php
                    $authors = $db->table('authors')
                        ->select('authors.author', 'authors.book_id')
                        ->where('authors.book_id = ' . $book->id())
                        ->order('author', 'ASC')
                        ->all();
                    foreach ($authors as $author) {
                        echo '<a href="display?author=' . urlencode($author->author()) . '">' . $author->author() . '</a><br />';
                    }
                    ?>
                </p>
                <p>
                    <?php echo $book->year() ?>
                </p>
            </div>
        </div>
    <?php endforeach; ?>

    <?php
    if ($books->pagination()->hasPages()) {

        if ($books->pagination()->hasPrevPage()) {
            if ($id == '') {
                $pagenum = '1';
            } else {
                $pagenum = $id;
            }
            $prevpage = $pagenum - 1;
            echo '<a class="prevpage" href="page?' . $prevpage . '" >&larr; ' . $lang['INDEX_PAGINATION_PREV'] . '</a>';
        }
        if ($books->pagination()->hasNextPage()) {
            if ($id == '') {
                $pagenum = '1';
            } else {
                $pagenum = $id;
            }
            $nextpage = $pagenum + 1;
            echo '<a class="nextpage" href="page?' . $nextpage . '" >' . $lang['INDEX_PAGINATION_NEXT'] . ' &rarr;</a>';
        }
    }
    ?>
</div>

<?php include_once('snippets/footer.php') ?>