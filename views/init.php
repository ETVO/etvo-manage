<?php
include_once CONTROL_DIR . '/util.php';

$site_title = $settings['site_title'] ?? '';

$data_source = 'system/users';

try {
    $stored_users = get_data_from_dir(ADMIN_DIR . '/' . $data_source . '.json') ?? [];
}
catch(Exception $e) {
}

$model = get_model($data_source) ?? die("CRITICAL: No Users Model file was found.");

$model['title'] = 'Initialize';
$model['desc'] = 'To initialize the system, you must register the first admin user';

$additional_attrs = [
    "access_level" => [
        "type" => "hidden",
        "value" => 'admin'
    ]
];

$form_id = 'init';

if (count($stored_users) > 0) {
    header("Location: /");
}

$status = false;
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['form_id'])) {
    include CONTROL_DIR . '/save_user.php';
}

if ($message != '') {
    $status_label = ($status) ? 'SUCCESS' : 'ERROR';
    echo '<script>alert("' . $status_label . '\n' . $message . '");';
    echo 'window.location.href="?show";</script>';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php $page_title = "Init - etvo-manage - $site_title"; ?>

    <?php include VIEW_DIR . '/partials/default-head.php'; ?>
</head>

<body>

<main class="init container">
    <?php
    require VIEW_DIR . '/users/add_new.php';
    ?>
</main>

<?php
include VIEW_DIR . '/partials/footer.php';

?>