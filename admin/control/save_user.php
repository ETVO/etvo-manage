<?php
include_once dirname(__FILE__) . '/../index.php';

include_once CONTROL_DIR . '/user_util.php';

$form_id = $_POST['form_id'] ?? exit;
$processed_data = $_POST;

unset($processed_data['form_action']);
unset($processed_data['data_source']);
unset($processed_data['has_image']);
unset($processed_data['save_in_dir']);
unset($processed_data['keep_fields']);

if ($form_id == 'add_new') {
    $response = register_user($processed_data);
    
    $status = $response[0];
    $message = $response[1];
}
else if ($form_id == 'edit') {
    $username = $_POST['username'] ?? exit;
    $original_username = $_POST['original_username'] ?? $username;
    $response = edit_user($original_username, $processed_data);

    $status = $response[0];
    $message = $response[1];
}
