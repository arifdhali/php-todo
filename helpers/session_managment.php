<?php
function initializeSession()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_name("Login_session");
        session_start();
        //$_SESSION['start'] = time();
    }
}

function redirectToCorrectPage() {
    initializeSession();

    if (isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    } else {
        header("Location: login.php");
        exit();
    }
}
?>
