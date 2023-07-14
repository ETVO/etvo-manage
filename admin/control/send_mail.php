<?php
include dirname(__FILE__) . '/util.php';
include dirname(__FILE__) . '/form_util.php';

$model = get_model('contact');

$is_ajax = isset($_GET['ajax']) ? $_GET['ajax'] : false;
$form_anchor = isset($_POST['form-anchor']) ? $_POST['form-anchor'] : '#contact';

$auth = array(
    'host' => 'mail.velvetcare.pt',
    'username' => 'admin@velvetcare.pt',
    'password' => 'secret'
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') :
    if (isset($model['honeypot']) && $model['honeypot']) {
        $honey_name = is_string($model['honeypot'])
            ? $model['honeypot']
            : 'honey';

        $honey = filter_input(INPUT_POST, $honey_name, FILTER_DEFAULT);

        // Validate honeypot field
        if (!empty($honey)) {
            http_response_code(405); // Set response code to indicate error
            
            echo $model['errors']['honeypot'] ?? 'Spam detected.';
            exit;
        }
    }

    $errors = array();
    foreach ($model['fields'] as $key => $field) {
        $value = $_POST[$key];

        if (!filter_field($value, $field['type'], $field['required'])) {
            $error = '';
            if ($field['type'] == 'email') {
                $error = $model['errors']['email_invalid'] ?? 'Please insert a valid email.';
            } else {
                $error = $model['errors']['required'] ?? '[label] is required.';
            }
            $error = str_replace('[label]', $field['label'], $error);
            $errors[$key] = $error;
        }
    }

    if (empty($errors)) {

        $to = $model['to']; // Replace with your email address
        $subject = $model['subject'];
        $from = $_POST['email'];

        $body = '';

        foreach ($model['fields'] as $key => $field) {
            $value = $_POST[$key];
            $label = $field['label'] ?? $field['placeholder'] ?? $key ?? '';

            if ($field['type'] == 'textarea') {
                $body .= "\n";
            }
            $body .= "$label: $value\n";
        }

        try {
            send_mail($auth, $from, $to, $subject, $body);
            $response = $model['response']['success'];
        } catch (Exception $e) {
            $response = $model['response']['error'];
            http_response_code(400);
        }

        if ($is_ajax) {
            echo $response;
        } else {
            $redirect = "/?form_status=success&form_message=$response&$form_anchor";
            header("Location: $redirect");
        }
    } else {
        if ($is_ajax) {
            echo json_encode($errors); // Send errors as JSON response
            http_response_code(400); // Set response code to indicate error
        } else {
            $redirect = "/?form_status=error&form_message=" . implode(',<br>', $errors) . "&$form_anchor";
            header("Location: $redirect");
        }
    }
endif;
