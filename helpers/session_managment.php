<?php

if (session_status() == PHP_SESSION_NONE) {    
    session_start();
}

define('SESSION_TIMEOUT', 600);

function initializeSession()
{
    if (!isset($_SESSION['time_stamp'])) {
        $_SESSION['time_stamp'] = time();
    }
}

// Function to check session validity and redirect if expired
function redirectToCorrectPage()
{
    initializeSession();

    if (!isset($_SESSION['user_id']) || (time() - $_SESSION['time_stamp']) > SESSION_TIMEOUT) {
        session_unset();
        session_destroy();
        header("location: login.php");
        exit();
    } else {
        $_SESSION['time_stamp'] = time();
    }
}
