<?php

$request = $_SERVER['REQUEST_URI'];
$viewDir = '/views/';

define('BASE_DIR', __DIR__);
define('VIEW_DIR', BASE_DIR . '/views/');
define('ADMIN_DIR', BASE_DIR . '/admin/');

$request = str_replace('/', '', $request);

switch ($request) {
    case '':
    case '/':
        require __DIR__ . $viewDir . 'index.php';
        break;

    case 'content':
        require __DIR__ . $viewDir . 'content.php';
        break;

    case 'projects':
        require __DIR__ . $viewDir . 'projects.php';
        break;

    case 'users':
        require __DIR__ . $viewDir . 'projects.php';
        break;


    default:
        http_response_code(404);
        require __DIR__ . $viewDir . '404.php';
}
