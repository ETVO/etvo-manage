<?php 

include_once dirname(__FILE__) . '/../const.php';

define('ALLOWED_ACCESS', array(
    '' => '*',
    '/' => '*',
    'content' => '*',
    'info' => '*',
    'users' => 'admin'
));