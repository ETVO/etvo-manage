<?php

$request = $_SERVER['REQUEST_URI'];
$viewDir = '/views/';

include_once './const.php';

$request = str_replace('/', '', $request);
$request = explode('?', $request)[0];

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

    default:
        http_response_code(404);
        header('Location: ' . BASE_URL);
}
