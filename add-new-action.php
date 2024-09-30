<?php
include "./db/config.php";
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$response = [
    "success" => false,
    "message" => []
];

$userID = $_SESSION['user_id'] ?? null;

if (!$userID) {
    $response['message'] = "User is not authenticated";
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $hasError = false;

    // Loop through POST data for validation
    foreach ($_POST as $key => $value) {
        $value = trim($value); // Sanitize input

        // Validation for empty fields
        if (empty($value)) {
            $response['message'][$key] = ucfirst(str_replace('_', ' ', $key)) . ' is required';
            $hasError = true;
        } elseif ($key === 'labor_cost') {
            if (!preg_match('/^\d+(\.\d{1,2})?$/', $value)) {
                $response['message'][$key] = 'Labor cost must be a valid number';
                $hasError = true;
            }
        } elseif ($key === 'start_date' || $key === 'end_date') {
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
                $response['message'][$key] = ucfirst(str_replace('_', ' ', $key)) . ' must be in YYYY-MM-DD format';
                $hasError = true;
            }
        }
    }

    // Date validation: end_date should not be before start_date
    if (!empty($_POST['start_date']) && !empty($_POST['end_date'])) {
        if (strtotime($_POST['end_date']) < strtotime($_POST['start_date'])) {
            $response['message']['end_date'] = 'End date cannot be before start date';
            $hasError = true;
        }
    }

    // If there's any validation error, stop and return the response
    if ($hasError) {
        echo json_encode($response);
        exit;
    } else {
        // Prepare SQL statement to insert data
        $sql = "INSERT INTO tasks (user_id, title, area, stage, start_date, end_date, labor_cost) VALUES (?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $connect->prepare($sql)) {
            $stmt->bind_param(
                "isssssd",
                $userID,
                $_POST['title'],
                $_POST['area'],
                $_POST['stage'],
                $_POST['start_date'],
                $_POST['end_date'],
                $_POST['labor_cost']
            );

            // Execute the prepared statement
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = "Task added successfully";
            } else {
                $response['message'] = "Error executing statement: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $response['message'] = "Failed to prepare statement: " . $connect->error;
        }

        // Return the response as JSON
        echo json_encode($response);
        $connect->close();
        exit;
    }
}
