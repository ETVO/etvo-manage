<?php 

include_once dirname(__FILE__) . '/../const.php';
include_once CONTROL_DIR . '/auth_util.php';

define('ALLOWED_ACCESS', array(
    '' => '*',
    '/' => '*',
    'content' => '*',
    'projects' => '*',
    'music' => '*',
    'users' => 'admin'
));