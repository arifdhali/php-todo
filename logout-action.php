<?php
include("./helpers/session_managment.php");
initializeSession();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
        session_destroy();
        $_SESSION = [];
        $response['status'] = true;
        $response['message'] = 'Logout successful';
    } else {
        $response['status'] = false;
        $response['message'] = 'Invalid request';
        exit;
    }
    echo json_encode($response);
}
