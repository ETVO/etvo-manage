<?php

include  VIEW_DIR . '/partials/header.php';
?>


<main class="index container text-center">
    <div class="heading">
        <h1 class="title">Bem vindo ao seu painel</h1>
        <p class="desc">Use o menu para editar o conteúdo do site.</p>
    </div>

    <div class="dashboard-options">
        <?php foreach ($menu_options as $key => $option) :
            if (is_access_allowed_here($_SESSION['user']['access_level'], $key)) :
                $href = BASE_URL . $option['link'];

                $is_current = ($key === $active_menu)
                    ? " class='nav-link active' aria-current='page'"
                    : " class='nav-link'";
        ?>
                <a href="<?= $href; ?>" <?= $is_current; ?>><?= $option['name']; ?></a>
        <?php endif;
        endforeach; ?>
    </div>
</main>


<?php
include  VIEW_DIR . '/partials/footer.php';

?>