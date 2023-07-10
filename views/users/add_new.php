<div class="add-new-user">
    <div class="heading">
        <h1 class="title"><?php echo $model['title'] ?></h1>
        <p class="desc"><?php echo $model['desc']; ?></p>
    </div>
    <input type="hidden" id="saveConfirmation">

    <a href="?show" class="back-to">Back to Users</a>


    <?php

    $attributes = $model['attributes'];
    $form_id = 'add_new';
    require VIEW_DIR . '/partials/model-form.php';
    ?>
</div>