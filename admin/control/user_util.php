<?php

include_once dirname(__FILE__) . '/../index.php';

define('USERS_STORAGE', ADMIN_DIR . '/system/users.json');

function register_user($user_data)
{
    if (isset($user_data['form_id']))
        unset($user_data['form_id']);

    if (!isset($user_data['username']) || !isset($user_data['password']))
        return [false, 'Both fields are required'];

    $username = filter_var(trim($user_data['username']));
    $raw_password = filter_var(trim($user_data['password']));
    $encrypted_password = password_hash($raw_password, PASSWORD_DEFAULT);

    $stored_users = json_decode(file_get_contents(USERS_STORAGE), true) ?? [];

    $user_data['username'] = $username;
    $user_data['password'] = $encrypted_password;

    $user_data['created_at'] = date('Y-m-d H:i');
    $user_data['updated_at'] = date('Y-m-d H:i');

    $user_data['active'] = true;

    $new_user = $user_data;

    // early birds get the worms

    if (empty($username) || empty($raw_password))
        return [false, 'Username and password are required'];

    if (username_exists($username, $stored_users))
        return [false, 'Username is taken'];

    // push to array, put to file
    array_push($stored_users, $new_user);
    if (file_put_contents(USERS_STORAGE, json_encode($stored_users))) {
        return [true, 'User registered successfully'];
    } else {
        return [false, 'Something went wrong. Please try again later.'];
    }
}


function edit_user($original_username, $user_data)
{
    if (isset($user_data['form_id']))
        unset($user_data['form_id']);

    if (!isset($user_data['username']))
        return [false, 'Username is required'];

    $username = filter_var(trim($user_data['username']));
    if ($user_data['password']) {
        $raw_password = filter_var(trim($user_data['password']));
        $encrypted_password = password_hash($raw_password, PASSWORD_DEFAULT);
    }

    $stored_users = json_decode(file_get_contents(USERS_STORAGE), true) ?? [];

    $user_data['username'] = $username;
    if ($encrypted_password)
        $user_data['password'] = $encrypted_password;
    else {
        // If password is empty, keep it as is
        unset($user_data['password']);
    }

    $user_data['updated_at'] = date('Y-m-d H:i');
    
    // Get user current info
    $new_user = get_user_by_username($original_username, $stored_users);
    if (!$new_user)
        return [false, 'User not found'];
        
    $new_user = array_replace($new_user, $user_data);

    // edit in array
    if (!$new_user || !replace_user_by_username($original_username, $new_user, $stored_users)) {
        return [false, 'Something went wrong. Please try again later.'];
    }

    // early birds get the worms

    if (file_put_contents(USERS_STORAGE, json_encode($stored_users))) {
        return [true, 'User edited successfully'];
    } else {
        return [false, 'Something went wrong. Please try again later.'];
    }
}

function toggle_user($username = null)
{
    if (!$username)
        return false;

    $username = filter_var(trim($username));

    $stored_users = json_decode(file_get_contents(USERS_STORAGE), true) ?? [];

    if (!empty($username) && $user = get_user_by_username($username, $stored_users)) {
        $new_user = $user;
        $new_user['active'] = !$user['active'];
    } else {
        return false;
    }

    // edit in array
    if (!replace_user_by_username($username, $new_user, $stored_users)) {
        return false;
    }

    // push to file
    if (file_put_contents(USERS_STORAGE, json_encode($stored_users))) {
        return [true, 'User edited successfully'];
    } else {
        return [false, 'Something went wrong. Please try again later.'];
    }
}


function remove_user($username = null)
{
    if (!$username)
        return false;

    $username = filter_var(trim($username));

    $stored_users = json_decode(file_get_contents(USERS_STORAGE), true) ?? [];

    if (empty($username) || !username_exists($username, $stored_users)) {
        return [false, 'User does not exist.'];
    }

    // edit in array
    if (!remove_user_by_username($username, $stored_users)) {
        return false;
    }

    // push to file
    if (file_put_contents(USERS_STORAGE, json_encode($stored_users))) {
        return [true, 'User removed successfully'];
    } else {
        return [false, 'Something went wrong. Please try again later.'];
    }
}



function get_user_data($username = null)
{
    if (!$username)
        return false;

    $username = filter_var(trim($username));

    $stored_users = json_decode(file_get_contents(USERS_STORAGE), true) ?? [];

    // push to file
    if (!empty($username) && $user = get_user_by_username($username, $stored_users)) {
        unset($user['password']);
        return [true, $user];
    } else {
        return [false, 'User not found.'];
    }
}

function username_exists($username, $stored_users)
{
    if ($stored_users)
        foreach ($stored_users as $user) {
            if ($username == $user['username']) return true;
        }
    return false;
}


function get_user_by_username($username, $stored_users)
{
    if ($stored_users)
        foreach ($stored_users as $user) {
            if ($username == $user['username']) return $user;
        }
    return false;
}

function replace_user_by_username($username, $new_user, &$stored_users)
{
    if ($stored_users)
        foreach ($stored_users as &$user) {
            if ($username == $user['username']) {
                $user = $new_user;
                return true;
            }
        }
    return false;
}

function remove_user_by_username($username, &$stored_users)
{
    if ($stored_users)
        foreach ($stored_users as $key => $user) {
            if ($username == $user['username']) {
                unset($stored_users[$key]);
                return true;
            }
        }
    return false;
}
