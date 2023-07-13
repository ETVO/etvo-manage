<?php

include_once dirname(__FILE__) . '/../index.php';

define('DATA_PATH', BASE_DIR . '/data/');
define('MODEL_PATH', ADMIN_DIR . '/model/');
define('SYSTEM_DATA_PATH', ADMIN_DIR . '/system/');

$settings = null;

// Read settings
$settings = get_system_data('settings');

function get_model($name)
{
    $model_json = file_get_contents(MODEL_PATH . "/$name.json");
    if (!$model_json) return null;
    return json_decode($model_json, true);
}

function get_block_model($id)
{
    return get_model("blocks/$id");
}

function get_data($name)
{
    $data_json = file_get_contents(DATA_PATH . "/$name.json");
    if (!$data_json) return null;
    return json_decode($data_json, true);
}

function get_system_data($name)
{
    $data_json = file_get_contents(SYSTEM_DATA_PATH . "/$name.json");
    if (!$data_json) return null;
    return json_decode($data_json, true);
}

function get_data_from_dir($dir)
{
    $data_json = file_get_contents($dir);
    if (!$data_json) return null;
    return json_decode($data_json, true);
}

function filter_blocks($blocks)
{
    $new_blocks = array();
    foreach ($blocks as $key => $block) {
        $new_key = explode(':', $key);
        if (count($new_key) > 1 && $new_key[1] == '0') {
            $new_blocks[$new_key[0]] = $block;
        } else {
            $new_blocks[$key] = $block;
        }
    }
    return $new_blocks;
}