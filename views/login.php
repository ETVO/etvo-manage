<?php
include_once CONTROL_DIR . '/auth_util.php';
include_once CONTROL_DIR . '/util.php';

$site_title = $settings['site_title'] ?? '';
$site_url = $settings['site_url'] ?? '';


$status = false;
$message = '';

if (isset($_SESSION['user'])) {
    header('Location: ' . BASE_URL);
}

if (isset($_GET['message'])) {
    $message = $_GET['message'];
}

if (isset($_GET['logout'])) {
    unset($_SESSION['user']);
    //destroy created session
    session_destroy();
    // Redirect to login page
    $message_query = ($message)
        ? '?message=' . $message
        : '';
    header("Location: " . BASE_URL . "/login" . $message_query);
}

// Handle the login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $response = check_credentials($username, $password);
    $status = $response[0];
    if ($status) {
        // Login successful
        $user = $response[1];
        $session_user = [
            'login_time' => time(),
            'username' => $user['username'],
            'access_level' => $user['access_level'],
            'active' => $user['active'],
        ];
        $_SESSION['user'] = $session_user;

        header('Location: ' . BASE_URL);
    } else {
        // Login error
        $message = $response[1];
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access - etvo-manage - <?php echo $site_title; ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link as="style" rel="stylesheet preload" crossorigin="anonymous" href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap">

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link href="https://cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">

    <link rel="stylesheet" href="./assets/css/bootstrap.css">
    <link rel="stylesheet" href="./assets/fonts/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="./assets/css/main.css">
</head>

<body>

    <div class="login page">
        <div class="container">
            <div class="navbar-brand etvo-manage-brand">
                <a class="etvo" target="_blank" href="https://etvo.me">etvo<span>manage</span></a>
                <a class="site-title" target="_blank" href="<?= $site_url; ?>"><?= $site_title; ?></a>
            </div>
            <div class="login-wrap">
                <form action="" method="post">
                    <?php if ($message) : ?>
                        <div class="form-message">
                            <?= $message; ?>
                        </div>
                    <?php endif; ?>
                    <div class="mb-3">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <div class="d-flex">
                        <!-- <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="remember" id="remember-me" name="remember-me">
                            <label class="form-check-label" for="remember-me">
                                Remember me
                            </label>
                        </div> -->
                        <button type="submit" class="btn btn-primary">Log in</button>
                    </div>
                </form>
            </div>
            <div class="forgot-password">
                <a data-bs-toggle="collapse" href="#forgot-password-msg" role="button" aria-expanded="false" aria-controls="forgot-password-msg">
                    Forgot your password?
                </a>
                <a href="?forgot"></a>

                <div class="collapse" id="forgot-password-msg">
                    <div class="card card-body">
                        To change a password, log in with the root admin account.
                        <br>
                        If you don't have access to it, please contact your website administrator.
                    </div>
                </div>
            </div>
        </div>
        <?php
        include VIEW_DIR . '/partials/footer.php';

        ?>
    </div>