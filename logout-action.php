<?php
$response = [
    'status' => false,
    'message' => ''
];
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_unset();
            session_destroy();
            $_SESSION = [];
            $response['status'] = true;
            $response['message'] = 'Logout successful';
        } else {
            $response['message'] = 'Session is not active';
        }
    } else {
        $response['message'] = 'Invalid request method';
    }
} else {
    $response['message'] = 'Invalid request';
}
echo json_encode($response);
exit;
