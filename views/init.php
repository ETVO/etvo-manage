<?php
include_once CONTROL_DIR . '/util.php';

$data_source = 'system/users';

$stored_users = get_data_from_dir(ADMIN_DIR . '/' . $data_source . '.json') ?? [];
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

<main class="init container">
    <?php
    require VIEW_DIR . '/users/add_new.php';
    ?>
</main>

<?php
include VIEW_DIR . '/partials/footer.php';

?>