<?php
session_start();

$request = $_SERVER['REQUEST_URI'];
$viewDir = '/views/';

include_once './const.php';
include_once CONTROL_DIR . '/util.php';

$request = str_replace([BASE_REQUEST, '/'], '', $request);
$request = explode('?', $request)[0];

if ($request != 'login' && $request != 'init') {
    if (!isset($_SESSION['user'])) {
        header("Location: " . BASE_URL . "/login");
        exit;
    }

    include_once CONTROL_DIR . '/auth_util.php';

    $response = authenticate($_SESSION['user'], $request);
    if (is_array($response)) {
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
        require BASE_DIR . $viewDir . 'index.php';
        break;

    case 'content':
    case 'projects':
    case 'music':
        $data_source = $request;
        require BASE_DIR . $viewDir . 'model-page.php';
        break;

    case 'users':
        require BASE_DIR . $viewDir . 'users.php';
        break;

    case 'login':
        require BASE_DIR . $viewDir . 'login.php';
        break;

    case 'init':
        require BASE_DIR . $viewDir . 'init.php';
        break;

    default:
        http_response_code(404);
        header('Location: ' . BASE_URL);
}
