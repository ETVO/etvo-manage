<?php

function is_subdomain() {
    return dirname($_SERVER['SCRIPT_NAME']) == '/';
}

$root_script_name = basename(__DIR__);


error_reporting(0);

define('BASE_REQUEST', is_subdomain() ? '' : $root_script_name);

define('BASE_DIR', __DIR__);
define('VIEW_DIR', BASE_DIR . '/views');
define('DATA_DIR', BASE_DIR . '/data');
define('ADMIN_DIR', BASE_DIR . '/admin');
define('CONTROL_DIR', ADMIN_DIR . '/control');

define('DEFAULT_HTTP', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http');
define('BASE_URL', DEFAULT_HTTP . '://' . $_SERVER['SERVER_NAME'] . '/' . $root_script_name);
define('VIEW_URL', BASE_URL . '/views');
define('DATA_URL', BASE_URL . '/data');
define('ADMIN_URL', BASE_URL . '/admin');
define('CONTROL_URL', ADMIN_URL . '/control');