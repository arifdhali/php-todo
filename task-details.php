<?php
include('./include/header.php');
include('./db/config.php');

$userID = $_SESSION['user_id'];
$username = $_SESSION['user_name'];

if (isset($_GET['id'])) {
    $taskID = $_GET['id'];    
    $sql = '
    SELECT T.id,T.title, T.start_date, T.end_date, T.labor_cost , TN.task_c_date
    FROM tasks T 
    LEFT JOIN task_notification TN ON T.id = TN.task_id
    WHERE T.user_id = ? AND T.id = ?';
    $stmt = $connect->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ii", $userID, $taskID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $task = $result->fetch_assoc();
        }
    } else {
        echo "Error preparing statement.";
    }
} else {
  header("Location: index.php");
}
?>

<div class="container">
    <table class="table table-hover">
        <thead class="table-dark">
            <tr>
                <th class="text-white" style="width: 10%;" scope="col">Task ID</th>
                <th class="text-white" style="width: 27%;" scope="col">Username</th>
                <th class="text-white" style="width: 20%;" scope="col">Title</th>
                <th class="text-white" style="width: 10%;" scope="col">Start Date</th>
                <th class="text-white" style="width: 10%;" scope="col">Closed Date</th>
                <th class="text-white" style="width: 10%;" scope="col">Closed Time</th>
                <th class="text-white" style="width: 17%;" scope="col">Labour Cost</th>
                <th class="text-white" style="width: 10%;" scope="col">Invoice</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($result as $item) {
            ?>
                <tr>
                    <td valign="middle" scope="row"><?= $item['id'] ?></td>
                    <td valign="middle" scope="row"><?= $username ?></td>
                    <td valign="middle" scope="row"><?= $item['title'] ?></td>
                    <td valign="middle" scope="row"><?= $item['start_date'] ?></td>
                    <td valign="middle" scope="row"><?= date('Y-m-d', strtotime($item['task_c_date']))  ?></td>
                    <td valign="middle" scope="row"><?= date('H:i:s A', strtotime($item['task_c_date']))  ?></td>
                    <td valign="middle" scope="row">$<?= $item['labor_cost'] ?></td>
                    <td valign="middle" scope="row"><a href="<?= $item['id'] ?>" download class="btn btn-success">Download</a></td>
                </tr>
            <?php  }

            ?>

        </tbody>
    </table>
</div>
<?php
include('./include/footer.php');
?>