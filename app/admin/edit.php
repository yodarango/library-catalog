<?php include_once('snippets/admin_header.php'); ?>
<h2>
    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit item
</h2>

<div id="item-list">

    <?php

    $collection = $db->table('books');

    $url = $_SERVER['REQUEST_URI'];
    $id = parse_url($url, PHP_URL_QUERY);
    if (strpos($id, 'id=') !== FALSE) {
        $bookid = str_replace('id=', '', $id);

        $item = $collection->find($bookid);
        $filename = $item->bookfile();

        if (isset($_POST['submit'])) { // check if form was submitted

            // =========================== UPLOAD

            if (isset($_FILES['files']) && $_FILES['files'] != '') {

                $old_filename = $item->bookfile();

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
                            // then we move it to 'path/to/my/uploads'
                            $result = $file->put('./ebooks');
                            $error = $result ? '' : 'Error moving file';
                        }
                    } else {
                        // oopps!
                        $error = $file->get_error();
                    }
                    if ($file->name != '') {
                        $filename = $file->name;
                        unlink('./ebooks/' . $old_filename);
                    }
                    // echo $file->name.' - '.($error ? ' [FAILED] '.$error : ' Succeeded!');
                    // echo '<br />'; 
                }
            }

            // =========================== UPLOAD

            $collection = $db->table('books');
            $insert_author = $_POST['author'];
            $insert_genre = $_POST['genre'];
            $insert_title = $_POST['title'];
            $insert_isbn = $_POST['isbn'];
            $insert_publisher = $_POST['publisher'];
            $insert_year = $_POST['year'];
            $insert_description = $_POST['description'];
            $insert_imgpath = $_POST['imgpath'];
            $insert_location = $_POST['location'];
            $insert_filename = $filename;

            if (isset($_POST['islent'])) {

                $insert_islent = $_POST['islent'];
                $insert_lentto = $_POST['lentto'];
                $insert_lentat = $_POST['lentat'];

                if (!isset($_POST['isebook'])) {
                    if ($id = $collection->where('id', '=', $_POST['id'])->update(array(
                        'title' => $insert_title,
                        'isbn' => $insert_isbn,
                        'publisher' => $insert_publisher,
                        'year' => $insert_year,
                        'description' => $insert_description,
                        'imgpath' => $insert_imgpath,
                        'location' => $insert_location,
                        'islent' => $insert_islent,
                        'lentto' => $insert_lentto,
                        'lentat' => $insert_lentat,
                        'a_str' => $insert_author,
                        'g_str' => $insert_genre,
                        'doctype' => 'paper'
                    ))) {
                    }
                } else {
                    if ($id = $collection->where('id', '=', $_POST['id'])->update(array(
                        'title' => $insert_title,
                        'isbn' => $insert_isbn,
                        'publisher' => $insert_publisher,
                        'year' => $insert_year,
                        'description' => $insert_description,
                        'imgpath' => $insert_imgpath,
                        'location' => $insert_location,
                        'islent' => $insert_islent,
                        'lentto' => $insert_lentto,
                        'lentat' => $insert_lentat,
                        'a_str' => $insert_author,
                        'g_str' => $insert_genre,
                        'doctype' => 'ebook',
                        'bookfile' => $insert_filename
                    ))) {
                    }
                }
            } else {

                if (!isset($_POST['isebook'])) {

                    if ($id = $collection->where('id', '=', $_POST['id'])->update(array(
                        'title' => $insert_title,
                        'isbn' => $insert_isbn,
                        'publisher' => $insert_publisher,
                        'year' => $insert_year,
                        'description' => $insert_description,
                        'imgpath' => $insert_imgpath,
                        'location' => $insert_location,
                        'a_str' => $insert_author,
                        'g_str' => $insert_genre,
                        'doctype' => 'paper'

                    ))) {
                    }
                } else {

                    if ($id = $collection->where('id', '=', $_POST['id'])->update(array(
                        'title' => $insert_title,
                        'isbn' => $insert_isbn,
                        'publisher' => $insert_publisher,
                        'year' => $insert_year,
                        'description' => $insert_description,
                        'imgpath' => $insert_imgpath,
                        'location' => $insert_location,
                        'a_str' => $insert_author,
                        'g_str' => $insert_genre,
                        'doctype' => 'ebook',
                        'bookfile' => $insert_filename

                    ))) {
                    }
                }
            }

            $insert_author = $_POST['author'];
            $author_collection = $db->table('authors');
            $author_collection->where('book_id', '=', $bookid)->delete();

            if (strpos($insert_author, ';') !== false) {
                if (substr($insert_author, -1) == ';') {
                    $insertable_author = substr($insert_author, 0, -1);
                } else {
                    $insertable_author = $insert_author;
                }
                $authors = explode(";", $insertable_author);
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

                if ($id = $author_collection->insert(array(
                    'author' => $insert_author,
                    'book_id' => $bookid
                ))) {
                }
            }

            $insert_genre = $_POST['genre'];
            $genre_collection = $db->table('genres');
            $genre_collection->select('*')
                ->where('book_id', '=', $bookid)
                ->delete();

            if (strpos($insert_genre, ',') !== false) {
                if (substr($insert_genre, -1) == ',') {
                    $insertable_genre = substr($insert_genre, 0, -1);
                } else {
                    $insertable_genre = $insert_genre;
                }
                $genres = explode(",", $insertable_genre);
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

            echo '<p>' . 'Item successfully modified. ' . '<a href="display?id=' . $_POST['id'] . '">' . 'Go back to the item' . '</a>.</p>';
        } else {
    ?>

            <form action="" method="post" enctype="multipart/form-data">

                <input type="hidden" name="id" value="<?php echo $item->id() ?>" /> <label
                    class="add-new-item"><i class="fa fa-user" aria-hidden="true"></i>
                    echo 'Author<span>(s) &ndash; separated by semicolon (;)</span>' </label>
                <?php $authors = $db->table('authors')->select('author')->where('book_id', '=', $bookid)->all(); ?>
                <input class="add-item-input" type="text" name="author"
                    value="<?php $y = $authors->count();
                            $i = 1;
                            foreach ($authors as $author) {
                                echo ($author->author());
                                if ($i != $y) {
                                    echo ('; ');
                                    $i++;
                                }
                            } ?>" />
                <label class="add-new-item"><i class="fa fa-font" aria-hidden="true"></i>
                    Add title</label> <input
                    class="add-item-input" type="text" name="title"
                    value="<?php echo $item->title() ?>" required /> <label
                    class="add-new-item"><i class="fa fa-barcode" aria-hidden="true"></i>
                    Add SBN label</label> <input
                    class="add-item-input" type="text" name="isbn"
                    value="<?php echo $item->isbn() ?>" /> <label class="add-new-item"><i
                        class="fa fa-building" aria-hidden="true"></i> Add publisher label</label>
                <input class="add-item-input" type="text" name="publisher"
                    value="<?php echo $item->publisher() ?>" /> <label
                    class="add-new-item"><i class="fa fa-calendar" aria-hidden="true"></i>
                    Add year label </label> <input
                    class="add-item-input" type="text" name="year"
                    value="<?php echo $item->year() ?>" /> <label class="add-new-item"><i
                        class="fa fa-tag" aria-hidden="true"></i>Genre label</label>
                <?php $genres = $db->table('genres')->select('genre')->where('book_id', '=', $bookid)->all(); ?>
                <input class="add-item-input" type="text" name="genre"
                    value="<?php $z = $genres->count();
                            $j = 1;
                            foreach ($genres as $genre) {
                                echo ($genre->genre());
                                if ($j != $z) {
                                    echo (', ');
                                    $j++;
                                }
                            } ?>" />
                <label class="add-new-item"><i class="fa fa-file-image-o"
                        aria-hidden="true"></i> Cover label</label>
                <input class="add-item-input" type="text" name="imgpath"
                    value="<?php echo $item->imgpath() ?>" /> <label class="add-new-item"><i
                        class="fa fa-align-left" aria-hidden="true"></i> Description label</label>
                <textarea class="add-item-input" type="text" name="description"><?php echo $item->description() ?></textarea>
                <label class="add-new-item"><i class="fa fa-compass"
                        aria-hidden="true"></i><?php echo 'Location label' ?></label>
                <input class="add-item-input" type="text" name="location"
                    value="<?php echo $item->location() ?>" />

                <!-- <div class="book-ebook">
                    <input type="checkbox" name="isebook" id="ifebook"
                        class="showHideCheck_ebook" <?php if ($item->doctype() == 'ebook') {
                                                        echo 'checked';
                                                    } ?> /><label for="ifebook"></label> <label
                        class="add-new-item"><?php echo $lang['ADD_IFEBOOK_LABEL'] ?></label>

                    <div class="showLending">

                        <label class="add-new-item"><i class="fa fa-file-text-o" aria-hidden="true"></i> <?php echo $lang['EDIT_EBOOK_CURRENTFILE'] ?></label>
                        <p>
                            <?php
                            if ($item->bookfile() != NULL) {
                                echo '<a href="ebooks/' . $item->bookfile() . '">' . $item->bookfile() . '</a>';
                            } else {
                                echo $lang['EDIT_EBOOK_NOCURRENTFILE'];
                            }
                            ?>
                        </p>

                        <label class="add-new-item"><i class="fa fa-upload"
                                aria-hidden="true"></i> <?php echo $lang['EDIT_EBOOK_ADDNEWFILE'] ?></label>
                        <input class="upload" type="file" name="files[]" />
                    </div>
                </div> -->

                <div class="book-lent">
                    <input type="checkbox" name="islent" id="iflent"
                        class="showHideCheck"
                        <?php if ($item->islent() == 'on') {
                            echo 'checked';
                        } ?> /><label
                        for="iflent"></label> <label class="add-new-item"><?php echo 'This book is lent' ?></label>

                    <div class="showLending">
                        <label class="add-new-item"><i class="fa fa-user-circle-o"
                                aria-hidden="true"></i> <?php echo 'Lent to' ?></label>
                        <input type="text" class="add-item-input" name="lentto"
                            value="<?php echo $item->lentto() ?>"> <label class="add-new-item"><i
                                class="fa fa-calendar-check-o" aria-hidden="true"></i> <?php echo 'Lent at' ?></label>
                        <input type="text" class="add-item-input" name="lentat"
                            value="<?php echo $item->lentat() ?>">
                    </div>
                </div>

                <input class="add-item-submit" type="submit"
                    value="Save" name="submit" /> <input
                    class="add-item-submit cancel-this" type="button" name="cancel"
                    value="Cancel"
                    onClick="window.location='display?<?php echo $id; ?>';" />

            </form>

    <?php }
    } ?>

    <div class="clear"></div>

</div>
<?php include_once('snippets/admin_footer.php') ?>