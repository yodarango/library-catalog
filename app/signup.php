<?php
session_start();
include_once('config/config.php');
include_once('toolkit/bootstrap.php');

if (isset($lang)) {
    include_once('./languages/' . $lang . '.php');
} else {
    include_once('./languages/en-US.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // remove all space from username
    $newUsername = str_replace(' ', '', trim($_POST['username']));
    $newUserPassword = trim($_POST['password']);
    $errors = [];
    $successMsgs = [];

    // Validate input
    if (empty($username)) {
        $errors[] = 'Username is required.';
    }
    if (empty($password)) {
        $errors[] = 'Password is required.';
    }

    if (empty($errors)) {
        // Establish database connection
        $db = new Database(array(
            'type' => 'mysql',
            'host' => $hostname,
            'database' => $database,
            'user' => $username,
            'password' => $password
        ));

        // Check if username already exists
        $query = $db->table('users')
            ->where('user', '=', $newUsername)
            ->all();

        if ($query->count() > 0) {
            $errors[] = 'Username already exists.';
        } else {
            // Hash the password
            $hashed_password = password_hash($newUserPassword, PASSWORD_BCRYPT);

            // Insert new user into the database
            $insert = $db->table('users')
                ->insert(array(
                    'user' => $newUsername,
                    'password' => $hashed_password,
                    'status' => time()
                ));

            if ($insert) {
                $successMsgs[] = 'User created successfully. Please login with your username and password!';
            } else {
                $errors[] = 'Failed to create user. Please try again.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.danielrangel.net/fullds.min.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STWC | Sign Up</title>
</head>

<body>
    <?php
    if (!empty($errors)) {
        echo '<div class="p-4 bg-danger">';
        foreach ($errors as $error) {
            echo '<p class="color-alpha">' . htmlspecialchars($error) . '</p>';
        }
        echo '</div>';
    }
    ?>

    <?php
    if (!empty($successMsgs)) {
        echo '<div class="p-4 bg-success">';
        foreach ($successMsgs as $msg) {
            echo '<p class="color-beta">' . htmlspecialchars($msg) . '</p>';
        }
        echo '</div>';
    }
    ?>

    <header class="p-3 bg-zeta w-100 mb-6">
        <div class="d-flex align-items-center justify-content-between">
            <a class="header-logo flex-shrink-0" href="index">
                <img src="assets/icons/favicon.png" alt="Library icon ">
            </a>
            <div>
                <h1 class="text-end">Welcome</h1>
            </div>
        </div>
    </header>

    <?php if (empty($successMsgs)) { ?>
        <section id="setup">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="auth-form d-bock m-auto">
                <p class="text-center mb-4">Please login to start using the STWC services.</p>
                <div class="mb-4">
                    <label class="d-block mb-2"><?php echo 'Username'; ?></label>
                    <input type="text"
                        name="username" required class="p-2 border border-delta w-100" />

                </div>
                <script type="text/javascript">
                    function changeVisibility() {
                        var x = document.getElementById("password");
                        if (x.type === "password") {
                            x.type = "text";
                        } else {
                            x.type = "password";
                        }

                        // change icon 
                        var icon = document.querySelector('.fa-eye');
                        if (icon.classList.contains('fa-eye')) {
                            icon.classList.remove('fa-eye');
                            icon.classList.add('fa-eye-slash');
                        } else {
                            icon.classList.remove('fa-eye-slash');
                            icon.classList.add('fa-eye');
                        }
                    }
                </script>
                <div class="mb-4">
                    <label class="d-block mb-2"><?php echo 'Password'; ?></label>
                    <div class="d-flex align-items-center justify-content-start column-gap-2">
                        <input
                            type="password" id="password" name="password" required class="p-2 border border-delta w-100" />
                        <button class="bg-nu p-0" onclick="changeVisibility();" type="button"><i class="fa fa-eye color-alpha"></i></button>
                    </div>
                </div>
                <div>

                    <button class="w-100 bg-delta w-100" type="submit" name="submit">Signup</button>
                </div>
            </form>
        </section>
    <?php } else { ?>
        <section class="auth-form m-auto mt-8">
            <a class="w-100 bg-epsilon d-block btn color-beta" href="/login">Login</a>
        </section>
    <?php } ?>

</body>

</html>