<?php
if (!isset($attributes)) die('No attributes were found...');
?>

<form action="<?= $form_action ?? ''; ?>" method="POST" class="model row w-100 m-0" enctype="multipart/form-data">
    <input type="hidden" name="form_id" value="<?= $form_id ?? ''; ?>">
    <input type="hidden" name="data_source" value="<?php echo $data_source; ?>">
    <div class="model-view col-9">
        <?php foreach ($attributes as $key => $field) :

            $value = $data[$key] ?? null;

            $key = explode(':', $key)[0];
            render_field($key, $field, $value);
        endforeach; ?>

        <?php if (isset($additional_attrs)) :
            foreach ($additional_attrs as $key => $field) :

                $value = $field['value'] ?? null;

                $key = explode(':', $key)[0];
                render_field($key, $field, $value);
            endforeach;
        endif; ?>
    </div>
    <div class="col-3">
        <div class="model-sidebar">
            <button class="btn btn-primary" type="submit">Save</button>
            <small>Changes are <b><i>NOT</i></b> saved automatically</small>
        </div>
    </div>
</form>