<?php
include("./db/config.php");

session_start();


$response = [
    'status' => false,
    'message' => []
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate input fields
    foreach ($_POST as $key => $value) {
        if (empty($value)) {
            $response['message'][$key] = ucfirst($key) . ' is required';
        }
    }

    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message']['email'] = 'Email is not valid';
    }

    if (!empty($response['message'])) {
        echo json_encode($response);
        exit;
    }

    $loginQuery = 'SELECT * FROM users WHERE user_email = ?';
    $stmt = $connect->prepare($loginQuery);

    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user['user_password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['user_name'];
                $response['status'] = true;
                $response['message'] = "User logged in successfully";
                $response['redirect'] = "index.php";
            } else {
                $response['message']['password'] = 'Invalid password';
            }
        } else {
            $response['message']['email'] = 'User not found';
        }

        $stmt->close();
    } else {
        $response['message'] = 'Error preparing the query';
    }

    echo json_encode($response);
    $connect->close();
}
?>
