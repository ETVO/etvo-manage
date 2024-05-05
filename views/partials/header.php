<?php

include_once CONTROL_DIR . '/blocks_util.php';
include_once CONTROL_DIR . '/auth_util.php';

$site_title = $settings['site_title'] ?? '';

if (!isset($active_menu))
    $active_menu = 0;

$main_link = BASE_URL;


// Get menu options from settings, if unset, set default menu options
$menu_options = $settings['menu_options'] ?? array(
    'content' => 'Content',
    'users' => 'Users'
);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php $page_title = "Manage $site_title"; ?>

    <?php include VIEW_DIR . '/partials/default-head.php'; ?>
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-md">
            <div class="container">
                <div class="navbar-brand etvo-manage-brand">
                    <a class="etvo" href="<?= $main_link ?>">etvo<span>manage</span></a>
                    <a class="site-title" href=<?= $settings['site_url'] ?> target="_blank"><?php echo $site_title; ?></a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#manageNavbar" aria-controls="manageNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="bi-list"></span>
                </button>
                <div class="collapse navbar-collapse" id="manageNavbar">
                    <ul class="navbar-nav ms-auto mb-2 mb-md-0">
                        <?php foreach ($menu_options as $key => $name) :
                            if (is_access_allowed_here($_SESSION['user']['access_level'], $key)) :
                                $href = BASE_URL . $key;

                                $is_current = ($key === $active_menu)
                                    ? " class='nav-link active' aria-current='page'"
                                    : " class='nav-link'";
                        ?>
                                <li class="nav-item" id="<?php echo $key; ?>">
                                    <a href="<?= $href; ?>" <?= $is_current; ?>><?= $name; ?></a>
                                </li>
                        <?php endif;
                        endforeach; ?>
                    </ul>
                    <div class="logged-in  ms-0 ms-md-3">
                        <button class="dropdown-toggle btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="bi-person"></span>
                            <span class="username">
                                <?= $_SESSION['user']['username'] ?? header('Location: ' . BASE_URL . '/login/?logout'); ?>
                            </span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>/login/?logout">Log Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>