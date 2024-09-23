<?php
include_once("./helpers/session_managment.php");
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    session_destroy();
    $response = [
        'success' => true,
        'message' => 'Session destroyed successfully'
    ];

    echo json_encode($response);
}
