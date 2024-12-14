<?php
include_once('app/admin/snippets/admin_header.php'); ?>

<?php

$coffeeId = isset($_POST['id']) ? $_POST['id'] : null;

$url = $_SERVER['REQUEST_URI'];
$parseUrl = parse_url($url, PHP_URL_QUERY);
$urlId = str_replace('id=', '', $parseUrl);

// get the coffee for the id
$collection = $db->table('coffees');
$coffee = $collection->find($urlId);

$errors = [];
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $thumbnail = '';

      if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['size'] > 0) {
            $file = $_FILES['thumbnail'];

            // Check file size (1MB max)
            if ($file['size'] > 1024 * 1024) {
                  array_push($errors, "File size exceeds 1MB.");
            }

            // Check file type
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($file['type'], $allowed_types)) {
                  array_push($errors, "Invalid image type. Allowed types: JPEG, PNG, GIF.");
            }

            // Save the image if no errors
            if (empty($errors)) {
                  $upload_dir = 'assets/images/uploads/';


                  if (!is_dir($upload_dir)) {
                        if (!mkdir($upload_dir, 0755, true) && !is_dir($upload_dir)) {
                              die("Sorry I could not create $upload_dir");
                        }
                  }

                  $file_name = uniqid() . '-' . basename($file['name']);
                  $file_path = $upload_dir . $file_name;

                  if (move_uploaded_file($file['tmp_name'], $file_path)) {
                        $thumbnail = $file_path;
                  } else {
                        array_push($errors, "Failed to upload image.");
                  }
            }

            $collection = $db->table('coffees');
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];

            if ($coffeeId) {
                  $collection->where('id', '=', $coffeeId)->update(array(
                        'name' => $name,
                        'description' => $description,
                        'price' => $price,
                        'thumbnail' => $thumbnail
                  ));
            } else {

                  $collection->insert(array(
                        'name' => $name,
                        'description' => $description,
                        'price' => $price,
                        'thumbnail' => $thumbnail
                  ));
            }
            if (empty($errors)) {
                  $success = 'Coffee edited successfully.';
                  // reload the page
                  header("Location: /admin-coffeeshop");
            }
      } else {
            $errors[0] = 'No file uploaded';
      }
}

// shorten the thumbnail path
$explodedThumbnail = explode("/", $coffee->thumbnail());
$thumbnail = end($explodedThumbnail);

?>

<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Create Coffee Item</title>

      <style>
            .toast-container {
                  animation: hide 3s forwards;
            }

            /* hide after 3 seconds */
            @keyframes hide {
                  0% {
                        opacity: 1;
                        height: auto;
                        padding: var(--dr-spacing-2);
                  }

                  99% {
                        opacity: 1;
                        height: auto;
                        padding: var(--dr-spacing-2);
                  }

                  100% {
                        opacity: 0;
                        height: 0;
                        padding: 0;
                  }

            }
      </style>
</head>

<body>

      <main class="main-content-area">
            <div>
                  <div class="d-flex align-items-center justify-content-start mb-4">
                        <a href="/admin-coffeeshop">Back</a>
                  </div>
                  <?php if ($success != ''): ?>
                        <p class="bg-sigma color-beta success p-2 toast-container"><?php echo $success; ?></p>
                  <?php endif; ?>
                  <?php if (count($errors) > 0): ?>
                        <?php foreach ($errors as $error) : ?>
                              <p class="p-2 color-alpha bg-phi "><?php echo $error; ?></p>
                        <?php endforeach; ?>
                  <?php endif; ?>
                  <p class="mb-6">Add a new item to the coffee shop below 🛍️</p>
                  <?php if ($coffee->thumbnail()): ?>
                        <div class="bg-gamma p-4 rounded">
                              <div class="rounded m-auto coffeeshop-thumbnail">
                                    <img src="<?= $coffee->thumbnail() ?>" alt="<?= $coffee->name() ?>">
                              </div>
                        </div>
                  <?php endif; ?>
                  <form method="post" enctype="multipart/form-data" action="">


                        <input type="hidden" name="id" value="<?= $coffee->id(); ?>">

                        <div class="my-4">
                              <label for="name" class="d-block mb-2">Name</label>
                              <input type="text" name="name" id="name" required class="border border-delta p-2 w-100" value="<?= $coffee->name(); ?>">
                        </div>

                        <div class="mb-4">
                              <label for="description" class="d-block mb-2">Description</label>
                              <textarea name="description" id="description" rows="5" required class="border border-delta p-2 w-100"><?= $coffee->description(); ?></textarea>
                        </div>
                        <div class="mb-4">
                              <label for="price" class="d-block mb-2">Price</label>
                              <input type="number" name="price" id="price" step="0.01" required class="border border-delta w-100 p-2" value="<?= $coffee->price(); ?>">
                        </div>
                        <div class="mb-4">
                              <label for="thumbnail" class="d-block mb-2">Thumbnail</label>
                              <?php if ($coffee->thumbnail()): ?>
                                    <div class="d-flex align-items-center justify-content-start column-gap-2 mb-2">
                                          <span id="fileName" class="file-name color-success"><?= $thumbnail ?></span>
                                          <i class="fa fa-check color-sigma" aria-hidden="true"></i>
                                    </div>
                              <?php endif ?>
                              <input type="file" name="thumbnail" id="thumbnail" accept="image/*" style="display: none;" value="<?= $thumbnail ?>">
                              <?php if ($coffee->thumbnail()): ?>
                                    <button type="button" id="customFileButton" class="bg-zeta color-beta w-100 rounded-0">Replace thumbnail</button>
                              <?php else: ?>
                                    <button type="button" id="customFileButton" class="bg-zeta color-beta w-100 rounded-0">Choose thumbnail</button>
                              <?php endif; ?>

                        </div>
                        <div>
                              <input type="submit" value="Update coffee" class="bg-delta p-2 w-100">
                        </div>
                  </form>
                  <script>
                        document.addEventListener('DOMContentLoaded', function() {
                              const fileInput = document.getElementById('thumbnail');
                              const customFileButton = document.getElementById('customFileButton');
                              const thumbnail = document.querySelector('.coffeeshop-thumbnail');
                              const fileNameSpan = document.getElementById('fileName');
                              const checkIcon = document.querySelector('.fa-check');

                              customFileButton.addEventListener('click', function() {
                                    fileInput.click();
                              });
                              thumbnail?.addEventListener('click', function() {
                                    fileInput.click();
                              });

                              fileInput.addEventListener('change', function() {
                                    if (fileInput.files.length > 0) {
                                          fileNameSpan.textContent = fileInput.files[0].name;
                                          checkIcon.style.display = 'block';
                                    } else {
                                          fileNameSpan.textContent = '';
                                          checkIcon.style.display = 'none';
                                    }

                                    // change the thumbnail image with the current file
                                    const thumbnail = document.querySelector('.coffeeshop-thumbnail img');
                                    thumbnail.src = URL.createObjectURL(fileInput.files[0]);

                              });
                        });
                  </script>

                  <script>
                        // function showToast(message) {
                        //       const toastContainer = document.querySelector('.toast-container');

                        //       const toast = document.createElement('div');
                        //       toast.className = 'toast';

                        //       toastContainer.appendChild(toast);

                        //       setTimeout(() => {
                        //             toast.classList.add('show');
                        //       }, 10);

                        //       setTimeout(() => {
                        //             toast.classList.remove('show');
                        //             setTimeout(() => {
                        //                   toastContainer.removeChild(toast);
                        //             }, 500);
                        //       }, 3000);
                        // }
                  </script>
            </div>
      </main>
</body>

</html>

<?php include_once('app/admin/snippets/admin_footer.php'); ?>