<?php
include("./db/config.php");

$response = [
    'status' => false,
    'msg' => []
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $usermobile = $_POST['mobile'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $profile_img = $_FILES['profile_img'];

    // Validation
    foreach ($_POST as $key => $value) {
        if (empty($value)) {
            $response['msg'][$key] = ucfirst($key) . ' is required';
        }
    }

    // Validate email format
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['msg']['email'] = 'Email is not valid';
    }

    // Password length check
    $limit = 6;
    if (!empty($password) && strlen($password) < $limit) {
        $response['msg']['password'] = 'Password should be a minimum of ' . $limit . ' characters';
    }

    if (!empty($response['msg'])) {
        echo json_encode($response);
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    if (!$hashed_password) {
        $response['msg']['password'] = 'Failed to hash password';
        echo json_encode($response);
        exit;
    }

    // Check if email already exists
    $exitsSql = 'SELECT user_email FROM users WHERE user_email = ?';
    $stmt = $connect->prepare($exitsSql);

    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        // Check if email exists
        if ($stmt->num_rows > 0) {
            $response['msg']['email'] = "Email already exists.";
            $stmt->close();
            echo json_encode($response);
            exit;
        }

        $stmt->close();
    } else {
        $response['msg'] = "Database error: could not prepare statement.";
        echo json_encode($response);
        exit;
    }

    // Handle file upload
    $upload_dir = './storage/users/';
    $file_name = date('Y-m-d_H-s') . '_user-' . $profile_img['name'];
    $target_file = $upload_dir . $file_name;
    if (move_uploaded_file($profile_img['tmp_name'], $target_file)) {
        $user_img = $target_file;
    } else {
        $response['msg']['profile_img'] = "Failed to upload image.";
        echo json_encode($response);
        exit;
    }

    // Insert new user
    $insertSql = 'INSERT INTO users (user_name, user_mobile, user_email, user_password, user_image) VALUES (?, ?, ?, ?, ?)';
    $insertStmt = $connect->prepare($insertSql);

    if ($insertStmt) {
        $insertStmt->bind_param('sssss', $username, $usermobile, $email, $hashed_password, $user_img);

        if ($insertStmt->execute()) {
            $response['status'] = true;
            $response['msg'] = "User registered successfully.";
        } else {
            $response['msg'] = "Error: Could not insert user.";
        }
        $insertStmt->close();
    } else {
        $response['msg'] = "Database error: could not prepare statement.";
    }

    // Return the final response
    echo json_encode($response);
}
