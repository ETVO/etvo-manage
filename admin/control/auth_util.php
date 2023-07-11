<?php

include_once dirname(__FILE__) . '/../index.php';

define('USERS_STORAGE', ADMIN_DIR . '/system/users.json');

if (!file_exists(USERS_STORAGE)) {
    create_users_file();
}
init_if_no_users();

function create_users_file()
{
    file_put_contents(USERS_STORAGE, '');
}

function init_if_no_users()
{
    $stored_users = json_decode(file_get_contents(USERS_STORAGE), true) ?? [];
    if (count($stored_users) == 0) {
        // No users registered
        header('Location: /init');
    }
}

function check_credentials($username, $password)
{

    if (!($username) || !($password))
        return [false, 'Both fields are required'];

    $username = filter_var(trim($username));
    $raw_password = filter_var(trim($password));

    $stored_users = json_decode(file_get_contents(USERS_STORAGE), true) ?? [];

    if (!($user = get_user_by_username($username, $stored_users))) {
        return [false, 'Incorrect username or password.'];
    }

    if (!$user['active'])
        return [false, 'User inactive.'];

    if (password_verify($raw_password, $user['password'])) {
        unset($user['password']);
        return [true, $user];
    } else {
        return [false, 'Incorrect username or password.'];
    }
}

function get_user_by_username($username, $stored_users)
{
    if ($stored_users)
        foreach ($stored_users as $user) {
            if ($username == $user['username']) return $user;
        }
    return false;
}


function authenticate(&$user, $request)
{
    if (!isset($user['username']))
        return [false, 'You are not logged in.'];

    $stored_users = json_decode(file_get_contents(USERS_STORAGE), true) ?? [];

    if (!($check_user = get_user_by_username($user['username'], $stored_users))) {
        return [false, 'User removed or username changed.'];
    }

    $user['access_level'] = $check_user['access_level'];
    $user['active'] = $check_user['active'];

    if (
        isset(ALLOWED_ACCESS[$request])
        && ALLOWED_ACCESS[$request] != '*'
        && ALLOWED_ACCESS[$request] != $user['access_level']
    ) {
        return [true, 'Not allowed to access this page.'];
    }

    if (!$user['active'])
        return [false, 'User deactivated.'];

    if (session_expired($user))
        return [false, 'Session expired'];

    return true;
}


function session_expired($user)
{
    // early bird gets the worm 
    if (!isset($user)) return true;

    $session_duration = 60 * 60 * 24 * 30; // 30 days
    if (isset($user['login_time']) && isset($user['username'])) {
        // If user has login time and username information
        if (((time() - $user['login_time']) > $session_duration))
            // If time logged in is bigger than max allowed duration
            return true;
    } else {
        // If user hasn't correct information set, return expired 
        return true;
    }
    return false;
}

function is_access_allowed_here($access_level, $request)
{
    if (!isset(ALLOWED_ACCESS[$request]))
        return false;

    if (is_array(ALLOWED_ACCESS[$request]) && in_array($access_level, ALLOWED_ACCESS[$request]))
        return true;

    if (ALLOWED_ACCESS[$request] == '*' || ALLOWED_ACCESS[$request] == $access_level)
        return true;

    return false;
}
