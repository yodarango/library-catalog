<?php include_once('snippets/admin_header.php') ?>

<h2>
    <i class="fa fa-trash" aria-hidden="true"></i>
</h2>

<div id="item-list">

    <?php
    $collection = $db->table('books');

    $url = $_SERVER['REQUEST_URI'];
    $id = parse_url($url, PHP_URL_QUERY);
    if (strpos($id, 'id=') !== FALSE) {
        $bookid = str_replace('id=', '', $id);

        $item = $collection->find($bookid);

        if (strpos($id, 'execute') !== FALSE) { // check if form was submitted

            $collection = $db->table('books');
            $author_collection = $db->table('authors');
            $genre_collection = $db->table('genres');

            if (($collection->where('id', '=', $bookid)->delete()) && ($author_collection->where('book_id', '=', $bookid)->delete()) && ($genre_collection->where('book_id', '=', $bookid)->delete())) {
            }

            echo '<div class="bg-success color-beta p-2 rounded d-flex align-items-center justify-content-between"><p class="w-100"> Item successfully deleted from your collection. </p> <a class="bg-beta color-success p-4 rounded d-block flex-shrink-0" href="/admin/library' . 'Back to my library' . '</a>.</div>';
        } else {
    ?>
            <p><strong>Warning!</strong> You are about to <strong>delete</strong> the following item from the database:</p>
            <ul class="delete">
                <li><strong><?php echo $item->title() ?></strong>
                    <?php

                    $author_collection = $db->table('authors');
                    $authors = $author_collection->select('author')
                        ->where('book_id', '=', $bookid)
                        ->all();
                    $y = $authors->count();
                    if ($y != 0) {
                        echo 'By';
                    }
                    $i = 1;
                    foreach ($authors as $author) {
                        echo '<strong>' . $author->author() . '</strong>';
                        if ($i != $y) {
                            echo ' & ';
                        }
                        $i++;
                    }
                    ?></strong></li>
            </ul>
            <p>Are you sure you want to delete this item?</p>
            <a class="bg-danger color-alpha p-4" href="admin-library-book-delete?<?php echo $id; ?>+execute">Yes</a>
            <a class="bg-success color-beta p-4" href="/?<?php echo $id; ?>">Cancel</a>
    <?php }
    } ?>

    <div class="clear"></div>

</div>
<?php include_once('snippets/admin_footer.php') ?>