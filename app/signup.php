<?php
session_start();
include_once('app/snippets/library_header-setup.php');
include_once('config/config.php');
include_once('toolkit/bootstrap.php');

if (isset($lang)) {
    include_once('./languages/' . $lang . '.php');
} else {
    include_once('./languages/en-US.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newUsername = trim($_POST['username']);
    $newUserPassword = trim($_POST['password']);
    $errors = [];

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
                    'status' => 0 // Assuming status 0 means offline
                ));

            if ($insert) {
                // Redirect to login page
                header('Location: login.php');
                exit;
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
    <title>Sign Up</title>
</head>

<body>
    <h1>Sign Up</h1>
    <?php
    if (!empty($errors)) {
        echo '<ul>';
        foreach ($errors as $error) {
            echo '<li>' . htmlspecialchars($error) . '</li>';
        }
        echo '</ul>';
    }
    ?>
    <form action="signup.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Sign Up</button>
    </form>
</body>

</html>