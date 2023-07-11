<?php

include_once CONTROL_DIR . '/util.php';
include_once CONTROL_DIR . '/auth_util.php';

$site_title = $settings['site_title'] ?? '';

if (!isset($active_menu))
    $active_menu = 0;

$main_link = '/';

$menu_options = array(
    'content' => array(
        'name' => 'Content',
        'link' => '/content/'
    ),
    'projects' => array(
        'name' => 'Projects',
        'link' => '/projects/'
    ),
    'users' => array(
        'name' => 'Users',
        'link' => '/users/'
    ),
);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>manage <?php echo $site_title; ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link as="style" rel="stylesheet preload" crossorigin="anonymous" href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap">

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link href="https://cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">

    <link rel="stylesheet" href="/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/assets/fonts/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="/assets/css/main.css">
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-md">
            <div class="container">
                <a class="navbar-brand etvo-manage-brand" href="<?= $main_link ?>">
                    <span class="etvo">etvo<span>manage</span></span>
                    <span class="site-title"><?php echo $site_title; ?></span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#manageNavbar" aria-controls="manageNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="bi-list"></span>
                </button>
                <div class="collapse navbar-collapse" id="manageNavbar">
                    <ul class="navbar-nav ms-auto mb-2 mb-md-0">
                        <?php foreach ($menu_options as $key => $option) :
                            if(is_access_allowed_here($_SESSION['user']['access_level'], $key)) :
                            $href = "href='{$option['link']}'";

                            $is_current = ($key === $active_menu)
                                ? " class='nav-link active' aria-current='page'"
                                : " class='nav-link'";
                        ?>
                            <li class="nav-item" id="<?php echo $key; ?>">
                                <a <?php echo $href . $is_current; ?>><?= $option['name']; ?></a>
                            </li>
                        <?php endif; endforeach; ?>
                    </ul>
                    <div class="logged-in">
                        <button class="dropdown-toggle btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="bi-person"></span>
                            <span class="username">
                                <?= $_SESSION['user']['username'] ?? header('Location: ' . BASE_URL . '/login/?logout'); ?>
                            </span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/login/?logout">Log Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>