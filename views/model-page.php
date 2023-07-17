<?php

$data_source = $data_source ?? 'content';
$active_menu = $active_menu ?? $data_source;

if (!defined('BASE_DIR')) {
    header("Location: /$data_source");
}

include VIEW_DIR . '/partials/header.php';

$form_action =  CONTROL_URL . '/save.php';

$model = get_model($data_source);
$data = get_data($data_source);

?>

<main class="<?=  $data_source; ?> container">
    <input type="hidden" id="saveConfirmation">
    <div class="heading">
        <h1 class="title"><?= $model['title']; ?></h1>
        <p class="desc"><?= $model['desc']; ?></p>
    </div>

    <?php
    $attributes = $model['attributes'];
    require VIEW_DIR . '/partials/model-form.php';
    ?>
</main>


<?php

include VIEW_DIR . '/partials/footer.php';

?>