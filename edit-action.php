<?php
include("./db/config.php");
$response = [
    'success' => false,
    'message' => []
];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $hasError = false;
    $userID = $_SESSION['user_id'];
    $taskID = $_POST['task_id'];

    // Validation    
    foreach ($_POST as $key => $value) {
        if (empty($value)) {
            $response['message'][$key] = ucfirst(str_replace('_', ' ', $key)) . ' is required';
            $hasError = true;
        } elseif ($key === 'labor_cost') {
            if (!preg_match('/^\d+(\.\d{1,2})?$/', $value)) {
                $response['message'][$key] = 'Labor cost must be a valid number';
                $hasError = true;
            }
        }
    }

    if ($hasError) {
        echo json_encode($response);
        exit;
    } else {
        $sql = 'UPDATE tasks SET title = ?, area = ?, stage = ?, end_date = ?, labor_cost = ? WHERE user_id = ? AND id = ?';
        $stmt = $connect->prepare($sql);

        if ($stmt) {

            $stmt->bind_param("ssssdii", $_POST['title'], $_POST['area'], $_POST['stage'], $_POST['end_date'], $_POST['labor_cost'], $userID, $taskID);
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = "Task updated successfully";
            } else {
                $response['message'] = "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $response['message'] = "Error preparing the query: " . $connect->error;
        }
        echo json_encode($response);
    }
}

$connect->close();
exit;
