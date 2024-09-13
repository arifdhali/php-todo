<?php
include "./db/config.php";
$response = [
    "success" => false,
    "message" => []
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $hasError = false;

    foreach ($_POST as $key => $value) {
        //validation
        if (empty($value)) {
            $response['message'][$key] = ucfirst(str_replace('_', ' ', $key)) . ' is required';
            $hasError = true;
        } elseif ($key === 'labor_cost') {
            if (!preg_match('/^\d+(\.\d{1,2})?$/', $value)) {
                $response['message'][$key] = 'Labor cost must be a valid number';
                $hasError = true;
            }
        }
        //var_dump($value);
    }


    // if  error
    if ($hasError) {
        echo json_encode($response);
        exit;
    } else {
        $sql = "INSERT INTO tasks (title, area, stage, start_date, end_date, labor_cost) VALUES (?, ?, ?, ?, ?, ?)";

        if ($stmt = $connect->prepare($sql)) {
            $stmt->bind_param("sssssd", $_POST['title'], $_POST['area'], $_POST['stage'], $_POST['start_date'], $_POST['end_date'], $_POST['labor_cost']);

            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = "Task added successfully";
                echo json_encode($response);
            } else {
                $response['success'] = false;
                $response['message'] = "Error: " . $stmt->error;
                echo json_encode($response);
            }

            $stmt->close();
        } else {
            $response['success'] = false;
            $response['message'] = "Failed to prepare statement: " . $connect->error;
            echo json_encode($response);
        }

        $connect->close();
        exit;

    }

}



?>