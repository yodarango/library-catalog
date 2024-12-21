<?php
// 1. First configure session parameters BEFORE starting the session
session_set_cookie_params(604800); // one week (value in seconds)

// 2. Then start the session
session_start();

// 3. Include your files and check login status
include_once('app/snippets/logged-in.php');
if (logged_in() == true) {
    redirect_to("index");
}
include_once('config/config.php');
include_once("toolkit/bootstrap.php");

if (isset($_POST['submit'])) {
    $appuser = $_POST['name'];
    $apppassword = $_POST['pass'];

    $db = new Database(array(
        'type' => 'mysql',
        'host' => $hostname,
        'database' => $database,
        'user' => $username,
        'password' => $password
    ));

    $query = $db->table('users')
        ->where('user', '=', $appuser)
        ->all();

    if ($query->count() != 1) {
        echo '<p class="p-4 bg-danger color-alpha">Error: Invalid username/password combination.</p>';
    } else {
        foreach ($query as $q) {
            $pw = $q->password();
            if (password::match($apppassword, $pw)) {
                // Regenerate session ID for security
                session_regenerate_id(true);

                // Authenticated, set session variables
                $_SESSION['user_id'] = $q->id();
                $_SESSION['username'] = $q->user();

                // update status to online
                $timestamp = time();
                $update = $db->table('users')
                    ->where('id', '=', $_SESSION['user_id'])
                    ->update(array(
                        'status' => $timestamp
                    ));

                redirect_to("index");
            } else {
                echo '<p class="p-4 bg-danger color-alpha">Error: Invalid username/password combination.</p>';
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.danielrangel.net/fullds.min.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>STWC | login</title>
</head>

<body>
    <header class="p-3 bg-zeta w-100 mb-6">
        <h1 class="text-center">Welcome</h1>
        <p class="text-center"><?php echo  'Please login to start using the STWC services. ' ?></p>
    </header>
    <section id="setup">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="auth-form d-bock m-auto">
            <div class="mb-4">
                <label class="d-block mb-2"><?php echo 'Username'; ?></label>
                <input type="text"
                    name="name" required class="p-2 border border-delta w-100" />

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
                        type="password" id="password" name="pass" required class="p-2 border border-delta w-100" />
                    <button class="bg-nu p-0" onclick="changeVisibility();" type="button"><i class="fa fa-eye color-alpha"></i></button>
                </div>
            </div>
            <div>
                <button class="w-100 bg-delta mb-4" type="submit" name="submit">Login</button>
                <a class="w-100 bg-epsilon d-block btn color-beta" href="/signup">Signup instead</a>
            </div>
        </form>
    </section>
</body>

</html>