<?php
// error_reporting(0);

header('Access-Control-Allow-Origin: http://etvo-web.test');

// To be configured when setting up system:
define('IS_SUBDOMAIN', true); # IF you change this, remember to change .htaccess
define('HOSTED_URL', 'etvo-manage.test');

global $root_script_name;

$root_script_name = basename(__DIR__);

define('BASE_REQUEST', IS_SUBDOMAIN ? '' : $root_script_name);

define('BASE_DIR', __DIR__);
define('VIEW_DIR', BASE_DIR . '/views');
define('DATA_DIR', BASE_DIR . '/data');
define('ADMIN_DIR', BASE_DIR . '/admin');
define('CONTROL_DIR', ADMIN_DIR . '/control');

define('DEFAULT_HTTP', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http');
define('BASE_URL', DEFAULT_HTTP . '://' . HOSTED_URL . '/' . BASE_REQUEST);
define('VIEW_URL', BASE_URL . '/views');
define('DATA_URL', BASE_URL . '/data');
define('ADMIN_URL', BASE_URL . '/admin');
define('CONTROL_URL', ADMIN_URL . '/control');


// define('WP_URL', 'http://blog.test');

function check_consts() {
  global $root_script_name;
  print_r([
    'root_script_name'   => $root_script_name,
    'BASE_REQUEST'      => BASE_REQUEST,
    'BASE_DIR'      => BASE_DIR,
    'VIEW_DIR'      => VIEW_DIR,
    'DATA_DIR'      => DATA_DIR,
    'ADMIN_DIR'     => ADMIN_DIR,
    'CONTROL_DIR'   => CONTROL_DIR,
    'DEFAULT_HTTP'  => DEFAULT_HTTP,
    'BASE_URL'      => BASE_URL,
    'VIEW_URL'      => VIEW_URL,
    'DATA_URL'      => DATA_URL,
    'ADMIN_URL'     => ADMIN_URL,
    'CONTROL_URL'   => CONTROL_URL
  ]);
}

// check_consts();