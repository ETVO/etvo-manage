<?php

include  VIEW_DIR . '/partials/header.php';
?>


<main class="index container text-center">
    <div class="heading">
        <h1 class="title">Welcome to your dashboard</h1>
        <p class="desc">Use the menu to edit your website's content</p>
    </div>

    <div class="dashboard-options">
        <?php foreach ($menu_options as $key => $name) :
            if (is_access_allowed_here($_SESSION['user']['access_level'], $key)) :
                $href = BASE_URL . $key;

                $is_current = ($key === $active_menu)
                    ? " class='nav-link active' aria-current='page'"
                    : " class='nav-link'";
        ?>
                <a href="<?= $href; ?>" <?= $is_current; ?>><?= $name; ?></a>
        <?php endif;
        endforeach; ?>
    </div>
</main>


<?php
include  VIEW_DIR . '/partials/footer.php';

?>