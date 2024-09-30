<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function initializeSession()
{
    if (!isset($_SESSION['time_stamp'])) {
        $_SESSION['time_stamp'] = time();
    }
}

function isAuthenticated()
{
    initializeSession();
    return isset($_SESSION['user_id']);
}

function redirectIfNotAuthenticated()
{
    if (!isAuthenticated()) {
        if (!headers_sent()) {
            header("Location: login.php");
            exit();
        }
    }
}

function checkSessionExpiration()
{
    $inactive = 60 * 60 * 24; 
    if (isset($_SESSION['time_stamp'])) {
        $session_life = time() - $_SESSION['time_stamp'];
        if ($session_life > $inactive) {
            session_unset();
            session_destroy();
            if (!headers_sent()) {
                header("Location: login.php");
                exit();
            }
        }
    }
}
