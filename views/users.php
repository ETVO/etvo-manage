<?php

$active_menu = 'users';
include VIEW_DIR . '/partials/header.php';

$data_source = 'system/users';

$stored_users = get_data_from_dir(ADMIN_DIR . '/' . $data_source . '.json') ?? [];
$model = get_model($data_source) ?? "CRITICAL: No Users Model file was found.";


$status = false;
$message = '';

$option = 'show';
if (isset($_GET['add_new'])) {
    $option = 'add_new';
}
if (isset($_GET['edit']) && isset($_GET['username'])) {
    include_once CONTROL_DIR . '/user_util.php';
    $option = 'edit';

    $username = $_GET['username'];
    $response = get_user_data($username);
    if ($response[0]) {
        $data = $response[1];
    } else {
        $status = $response[0];
        $message = $response[1];
    }
}
if (isset($_GET['show'])) {
    $option = 'show';
}
if (isset($_GET['toggle']) && isset($_GET['username'])) {
    include_once CONTROL_DIR . '/user_util.php';

    $username = $_GET['username'];
    $response = toggle_user($username);

    echo '<script>window.location.href="?show";</script>';
}

if (isset($_GET['remove']) && isset($_GET['username'])) {
    include_once CONTROL_DIR . '/user_util.php';

    $username = $_GET['username'];
?>
    <script>
        if (confirm('Are you sure you want to remove the user <?= $username; ?>?'))
            window.location.href = "?really_remove&username=<?= $username; ?>";
        else
            window.location.href = "?show";
    </script>
<?php
}

if (isset($_GET['really_remove']) && isset($_GET['username'])) {
    include_once CONTROL_DIR . '/user_util.php';

    $username = $_GET['username'];
    $response = remove_user($username);

    $status = $response[0];
    $message = $response[1];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['form_id'])) {
    include CONTROL_DIR . '/save_user.php';
}

if ($message != '') {
    $status_label = ($status) ? 'SUCCESS' : 'ERROR';
    echo '<script>alert("' . $status_label . '\n' . $message . '");';
    echo 'window.location.href="?show";</script>';
}

?>

<main class="users container">

    <?php switch ($option):

        case 'show':
            require VIEW_DIR . '/users/show.php';
            break;

        case 'add_new':
            require VIEW_DIR . '/users/add_new.php';
            break;

        case 'edit':
            require VIEW_DIR . '/users/edit.php';
            break;


    endswitch; ?>
</main>
<?php
include VIEW_DIR . '/partials/footer.php';

?>