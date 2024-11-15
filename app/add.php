<?php include_once('snippets/library_header.php') ?>

<h2>
    <i class="fa fa-plus" aria-hidden="true"></i><?php echo $lang['ADD_TITLE']; ?>
</h2>
<div id="item-list">

    <?php

    require_once('lib/class.file.php');
    require_once('lib/class.upload.php');

    if (isset($_POST['submit'])) { // check if form was submitted

        if (isset($_FILES['files'])) {
            $validations = array(
                'category' => array('ebook'), // validate only those files within this list
                'size' => 20 // maximum of 20mb
            );

            // create new instance
            $upload = new Upload($_FILES['files'], $validations);

            // for each file
            foreach ($upload->files as $file) {
                if ($file->validate()) {
                    // do your thing on this file ...
                    // ...
                    // say we don't allow audio files
                    if ($file->is('audio')) $error = 'Audio not allowed';
                    else {
                        // then get base64 encoded string to do something else ...
                        $filedata = $file->get_base64();

                        // or get the GPS info ...
                        $gps = $file->get_exif_gps();

                        // then we move it to 'path/to/my/uploads'
                        $result = $file->put('./ebooks');
                        $error = $result ? '' : 'Error moving file';
                    }
                } else {
                    // oopps!
                    $error = $file->get_error();
                }
                $filename = $file->name;
            }
        }


        // =========================== UPLOAD

        $collection = $db->table('books');

        $insert_author = mb_convert_encoding($_POST['author'], 'UTF-8', 'auto');
        $insert_title = $_POST['title'];
        $insert_isbn = $_POST['isbn'];
        $insert_publisher = $_POST['publisher'];
        $insert_year = $_POST['year'];
        $insert_description = $_POST['description'];
        $insert_genre = $_POST['genre'];
        $insert_imgpath = $_POST['imgpath'];
        $insert_owner = $_SESSION['user_id'];
        if (isset($filename)) {
            $insert_filename = $filename;
        } else {
            $insert_filename = NULL;
        }

        // insert the book into the db
        if ($id = $collection->insert(array(
            'title' => $insert_title,
            'isbn' => $insert_isbn,
            'publisher' => $insert_publisher,
            'year' => $insert_year,
            'description' => $insert_description,
            'imgpath' => $insert_imgpath,
            'a_str' => $insert_author,
            'g_str' => $insert_genre,
            'owner' => $insert_owner,
            'doctype' => 'ebook',
            'bookfile' => $insert_filename
        ))) {

            $bookid = $id;
        }

        // insert the author into the authors table. Keeping authors in a separate table allows 
        // to better filter by author.
        $author_collection = $db->table('authors');

        // if there are multiple authors, split them and insert each into the authors table
        if (strpos($insert_author, ';') !== false) {
            $authors = explode(";", $insert_author);
            foreach ($authors as $author) {

                $insert_author = trim($author);

                if ($id = $author_collection->insert(array(
                    'author' => $insert_author,
                    'book_id' => $bookid
                ))) {
                }
            }
        } else {
            $insert_author = $_POST['author'];
            if ($insert_author != '') {
                if ($id = $author_collection->insert(array(
                    'author' => $insert_author,
                    'book_id' => $bookid
                ))) {
                }
            }
        }


        // insert the genre into the genres table. Keeping genres in a separate table allows
        // to better filter by genre.
        $genre_collection = $db->table('genres');

        // if there are multiple genres, split them and insert each into the genres table
        if (strpos($insert_genre, ',') !== false) {
            $genres = explode(",", $insert_genre);
            foreach ($genres as $genre) {

                $insert_genre = trim($genre);

                if ($id = $genre_collection->insert(array(
                    'genre' => $insert_genre,
                    'book_id' => $bookid
                ))) {
                }
            }
        } else {
            $insert_genre = $_POST['genre'];
            if ($insert_genre != '') {
                if ($id = $genre_collection->insert(array(
                    'genre' => $insert_genre,
                    'book_id' => $bookid
                ))) {
                }
            }
        }
        echo '<p>' . $lang['ADDED_SUCCESS'] . '<a href="display?id=' . $bookid . '">' . $lang['ADDED_SUCCESS_REDIRECT'] . '</a>.</p>';
    } else {
    ?>

        <form action="" method="post" enctype="multipart/form-data">
            <label class="add-new-item"><i class="fa fa-user" aria-hidden="true"></i>
                <?php echo $lang['ADD_AUTHOR_LABEL'] ?></label> <input
                class="add-item-input" type="text" name="author" /><label
                class="add-new-item"><i class="fa fa-font" aria-hidden="true"></i>
                <?php echo $lang['ADD_TITLE_LABEL'] ?></label> <input
                class="add-item-input" type="text" name="title" required /> <label
                class="add-new-item"><i class="fa fa-barcode" aria-hidden="true"></i> <?php echo $lang['ADD_ISBN_LABEL'] ?></label>
            <input class="add-item-input" type="text" name="isbn" /> <label
                class="add-new-item"><i class="fa fa-building" aria-hidden="true"></i>
                <?php echo $lang['ADD_PUBLISHER_LABEL'] ?></label> <input
                class="add-item-input" type="text" name="publisher" /> <label
                class="add-new-item"><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo $lang['ADD_YEAR_LABEL'] ?></label>
            <input class="add-item-input" type="text" name="year" /> <label
                class="add-new-item"><i class="fa fa-tag" aria-hidden="true"></i> <?php echo $lang['ADD_GENRE_LABEL'] ?></label>
            <input class="add-item-input" type="text" name="genre" /> <label
                class="add-new-item"><i class="fa fa-file-image-o" aria-hidden="true"></i> <?php echo $lang['ADD_COVER_LABEL'] ?></label>
            <input class="add-item-input" type="text" name="imgpath" /> <label
                class="add-new-item"><i class="fa fa-align-left" aria-hidden="true"></i> <?php echo $lang['ADD_DESCRIPTION_LABEL'] ?></label>
            <textarea class="add-item-input" type="text" name="description"></textarea>

            <input class="add-item-submit" type="submit" name="submit"
                value="<?php echo $lang['ADD_ADDBUTTON'] ?>" /> <input
                class="add-item-submit cancel-this" type="button" name="cancel"
                value="<?php echo $lang['ADD_CANCELBUTTON'] ?>"
                onClick="window.location='index';" />
        </form>

    <?php } ?>

    <div class="clear"></div>

</div>

<?php include_once('snippets/library_footer.php') ?>