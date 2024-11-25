<?php
ob_start();
include_once('app/snippets/admin_header.php'); ?>

<?php


// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $thumbnail = '';
      $errors = [];

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

                  // echo '<script>console.log(' . json_encode(is_dir($upload_dir)) . ')</script>';
                  // return;
                  $file_name = uniqid() . '-' . basename($file['name']);
                  $file_path = $upload_dir . $file_name;

                  if (move_uploaded_file($file['tmp_name'], $file_path)) {
                        $thumbnail = $file_path;
                  } else {
                        array_push($errors, "Failed to upload image.");
                  }
            }
      } else {
            $errors[0] = 'No file uploaded';
      }

      $collection = $db->table('coffees');
      $name = $_POST['name'];
      $description = $_POST['description'];
      $price = $_POST['price'];

      // if ($thumbnail['error'] === 0) {
      //       $thumbnailName = $thumbnail['name'];
      //       $thumbnailTmp = $thumbnail['tmp_name'];
      //       $thumbnailPath = 'uploads/' . $thumbnailName;
      //       move_uploaded_file($thumbnailTmp, $thumbnailPath);
      // } else {
      //       $thumbnailPath = '';
      // }

      $collection->insert(array(
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'thumbnail' => $thumbnail
      ));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Create Coffee Item</title>
</head>

<body>
      <p class="mb-6">Add a new item to the coffee shop below 🛍️</p>
      <form method="post" enctype="multipart/form-data" action="">
            <?php if (isset($errors)): ?>
                  <?php foreach ($errors as $error) : ?>
                        <p class="p-2 bg-chi><?php echo $error; ?></p>
                  <?php endforeach; ?>
            <?php endif; ?>
            <?php if (isset($success)): ?>
                  <p class=" success"><?php echo $success; ?></p>
                  <?php endif; ?>
                  <div class="mb-4">
                        <label for="name" class="d-block mb-2">Name</label>
                        <input type="text" name="name" id="name" required class="border border-delta p-2 w-100">
                  </div>

                  <div class="mb-4">
                        <label for="description" class="d-block mb-2">Description</label>
                        <textarea name="description" id="description" rows="5" required class="border border-delta p-2 w-100"></textarea>
                  </div>
                  <div class="mb-4">
                        <label for="price" class="d-block mb-2">Price</label>
                        <input type="number" name="price" id="price" step="0.01" required class="border border-delta w-100 p-2">
                  </div>
                  <div class="mb-4">
                        <label for="thumbnail" class="d-block mb-2">Thumbnail</label>
                        <input type="file" name="thumbnail" id="thumbnail" accept="image/*">
                  </div>
                  <div>
                        <input type="submit" value="Add Coffee" class="bg-delta p-2 w-100">
                  </div>
      </form>
</body>

</html>

<?php ob_end_flush(); ?>

<?php include_once('app/snippets/admin_footer.php'); ?>