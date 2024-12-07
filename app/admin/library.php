<?php
include_once('snippets/admin_header.php');

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

<div class="d-flex align-items-center justify-content-end">
      <a href="/admin-library-book-add" class="btn btn-primary flex-shrink-0">
            <i class="fa fa-plus color-lambda" aria-hidden="true"></i>
            <span class=" color-lambda">Add new book</span>
      </a>
</div>
<h3 class="my-4">Browse all <?php echo $books->count() ?> books</h3>
<div class="item-list">

      <?php foreach ($books as $book): ?>
            <div class="book-card-admin d-flex align-items-start justify-content-start column-gap-2 bg-gamma p-4 rounded mb-4">
                  <a href="/admin-library-book?id=<?php echo $book->id() ?>" class="d-flex align-items-start justify-content-start  w-100">
                        <div class="book-card-admin-image">
                              <img src="<?php echo $book->imgpath() ? $book->imgpath() : 'assets/icons/book-thumbnail.png' ?>" alt="<?php echo $book->title() ?>">
                        </div>
                        <div class="book-card-admin-info p-2">
                              <h5 class="color-alpha mb-1">
                                    <?php echo $book->title(); ?>
                              </h5>
                              <p class="color-alpha p-0 color-zeta fs-6">
                                    <?php echo $book->author(); ?>
                              </p>
                              <p class="p-0 fs-6 color-alpha">
                                    <?php echo strlen($book->description()) > 100 ? substr($book->description(), 0, 100) . '...' : $book->description(); ?>
                              </p>
                        </div>
                  </a>
                  <a class="d-block" href="delete?<?php echo $bookid; ?>">
                        <button class="bg-danger p-4 color-alpha">
                              <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                  </a>
            </div>

      <?php endforeach; ?>
</div>
<?php include_once('snippets/admin_footer.php') ?>