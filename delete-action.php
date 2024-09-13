<?php
include('./db/config.php');
$response = [
    "status" => false,
];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $taskID = $_POST['id'];
    $sql = "DELETE FROM tasks WHERE id = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("i", $taskID);

    if ($stmt->execute()) {
        $response['status'] = true;
        $response['message'] = "Task deleted successfully";
        echo json_encode($response);
    } else {
        $response['status'] = false;
        $response['message'] = "Failed to task delete";
        echo json_encode($response);
    }
    $stmt->close();
    $connect->close();
}
