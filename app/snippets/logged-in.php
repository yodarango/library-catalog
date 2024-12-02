<?php
function logged_in()
{

    if (isset($_SESSION['username']) && isset($_SESSION['user_id'])) {
        return true;
    } else {
        return false;
    }
}

function  get_username()
{
    if (isset($_SESSION['username'])) {
        return $_SESSION['username'];
    } else {
        return false;
    }
}

function is_admin()
{
    if (isset($_SESSION['username']) && isset($_SESSION['user_id'])) {
        if ($_SESSION['username'] == 'admin') {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function redirect_to($url)
{
    header("Location: {$url}");
}
