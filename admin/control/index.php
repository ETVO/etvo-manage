<?php
session_start();

$request = $_SERVER['REQUEST_URI'];
$viewDir = '/views/';

include_once './const.php';

$request = str_replace('/', '', $request);
$request = explode('?', $request)[0];

if ($request != 'login') {
    if (!isset($_SESSION['user'])) {
        header("Location: " . BASE_URL . "/login");
        exit;
    }
    
    include_once CONTROL_DIR . '/auth_util.php';

    $response = authenticate($_SESSION['user'], $request);
    if (is_array($response)) {
        print_r($response);
        if ($response[0]) {
            header("Location: " . BASE_URL . "/");
        } else {
            header("Location: " . BASE_URL . "/login?logout&message={$response[1]}");
        }
    }
}

switch ($request) {
    case '':
    case '/':
        require __DIR__ . $viewDir . 'index.php';
        break;

    case 'content':
    case 'projects':
        $data_source = $request;
        require __DIR__ . $viewDir . 'model-page.php';
        break;

    case 'users':
        require __DIR__ . $viewDir . 'users.php';
        break;

    case 'login':
        require __DIR__ . $viewDir . 'login.php';
        break;

    default:
        http_response_code(404);
        header('Location: ' . BASE_URL);
}
