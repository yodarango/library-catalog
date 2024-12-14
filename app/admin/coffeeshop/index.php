<?php
include_once('app/admin/snippets/admin_header.php');

// get the search term from the post request
$term = isset($_POST['term']) ? $_POST['term'] : "";
$coffeeId = isset($_POST['delete-id']) ? $_POST['delete-id'] : null;

$collection = $db->table('coffees');


// or fetch if not filtering
$coffees = $collection
      ->select(['id', 'name', 'description', 'price', 'thumbnail'])
      ->order('id DESC')
      ->all();


//  delete a book from id 
if (!is_null($coffeeId) && $_SERVER["REQUEST_METHOD"] === "POST") {

      $item = $collection->find($coffeeId);

      if (isset($item)) {

            if (($collection->where('id', '=', $coffeeId)->delete())) {
            }

            header("Location: /admin-coffeeshop");
      }
}
?>

<div class="d-flex align-items-center justify-content-end">
      <a href="/admin-coffeeshop-coffee-add" class="btn btn-primary flex-shrink-0">
            <i class="fa fa-plus color-lambda" aria-hidden="true"></i>
            <span class=" color-lambda">Add new coffee</span>
      </a>
</div>
<?php if (count($coffees) == 0): ?>
      <div role="alert" class="bg-info rounded p-4">
            <p class="color-beta">No Coffees found.</p>
      </div>
<?php else: ?>
      <h3 class="my-4">Browse all <?php echo $coffees->count() ?> coffees</h3>
<?php endif; ?>
<div class="item-list">

      <?php foreach ($coffees as $coffee): ?>
            <?php $thumbnail = !is_null($coffee->thumbnail()) ? $coffee->thumbnail() : 'assets/icons/coffee-thumbnail.png' ?>
            <div class="coffee-card-admin d-flex align-items-start justify-content-start column-gap-2 bg-gamma p-4 rounded mb-4">
                  <div class="d-flex align-items-start justify-content-start column-gap-4 w-100">
                        <div class="coffee-card-admin-image">
                              <img src="<?= $thumbnail ?>" alt="<?php echo $coffee->title() ?>">
                        </div>
                        <div class="coffee-card-admin-info p-2">
                              <h5 class="color-alpha mb-1">
                                    <?php echo $coffee->name(); ?>
                              </h5>
                              <p class="p-0 fs-6 color-alpha">
                                    <?php echo strlen($coffee->description()) > 100 ? substr($coffee->description(), 0, 100) . '...' : $coffee->description(); ?>
                              </p>
                              <p class="color-alpha p-0 color-zeta fs-6">
                                    <?php echo $coffee->price(); ?>
                              </p>
                        </div>
                  </div>

                  <div class="flex-shrink-0 d-flex flex-column align-items-center justify-content-start row-gap-2">
                        <form action="/admin-coffeeshop" id="delete-id" method="post">
                              <input class="search-form p-2 rounded w-100 d-block" name="delete-id"
                                    value="<?php echo $coffee->id(); ?>" type="hidden" />
                              <button class="d-block bg-danger p-4 color-alpha" type="submit"
                                    value="Delete item">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                              </button>
                        </form>
                        <a href="/admin-coffeeshop-coffee-edit?id=<?php echo $coffee->id() ?>" class="btn d-block d-block color-alpha p-4 bg-lambda">
                              <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>

                  </div>
            </div>

      <?php endforeach; ?>
</div>

<?php include_once('app/admin/snippets/admin_footer.php') ?>