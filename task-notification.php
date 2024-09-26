
<?php
include "./db/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    date_default_timezone_set('Asia/Kolkata'); 
    $id =  $_POST['task_id'];
    $task_c_date = $_POST['task_c_date'];

    $sql = 'insert into task_notification (task_id,task_c_date,task_status) values (?,?, ?)';
    $task_status = "complete";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("iss", $id, $task_c_date, $task_status);
    if ($stmt->execute()) {
        $response['status'] = true;
        $response['msg'] = 'New notifications';
    } else {
        $response['message'] = "Error: " . $stmt->error;
    }
    echo json_encode($response);
}
$connect->close();
exit;
