<?php
include_once('snippets/admin_header.php');

// get the search term from the post request
$term = isset($_POST['term']) ? $_POST['term'] : "";
$bookId = isset($_POST['delete-id']) ? $_POST['delete-id'] : null;

$collection = $db->table('books');

$books = [];

// filter the books if it is a post request
if ($_SERVER["REQUEST_METHOD"] === "POST" && is_null($bookId)) {
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

//  delete a book from id 
if (!is_null($bookId) && $_SERVER["REQUEST_METHOD"] === "POST") {

      $item = $collection->find($bookId);

      if (isset($item)) {

            $collection = $db->table('books');
            $author_collection = $db->table('authors');
            $genre_collection = $db->table('genres');

            if (($collection->where('id', '=', $bookId)->delete()) && ($author_collection->where('book_id', '=', $bookId)->delete()) && ($genre_collection->where('book_id', '=', $bookId)->delete())) {
            }

            header("Location: /admin-library");
      }
}
?>

<div class="d-flex align-items-center justify-content-end">
      <a href="/admin-library-book-add" class="btn btn-primary flex-shrink-0">
            <i class="fa fa-plus color-lambda" aria-hidden="true"></i>
            <span class=" color-lambda">Add new book</span>
      </a>
</div>
<?php if (count($books) == 0): ?>
      <div role="alert" class="bg-info rounded p-4">
            <p class="color-beta">No books found.</p>
      </div>
<?php else: ?>
      <h3 class="my-4">Browse all <?php echo $books->count() ?> books</h3>
<?php endif; ?>
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

                  <form action="/admin-library" id="delete-id" method="post" class="d-flex align-items-center justify-content-start column-gap-2">
                        <input class="search-form p-2 rounded w-100 d-block" name="delete-id"
                              value="<?php echo $book->id(); ?>" type="hidden" />
                        <button class="d-block bg-danger p-4 color-alpha" type="submit"
                              value="Delete item">
                              <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                  </form>
            </div>

      <?php endforeach; ?>
</div>

<?php include_once('snippets/admin_footer.php') ?>