<?php
include("./include/header.php");
include_once('./db/config.php');

$userId = $_SESSION['user_id'];



$sql = 'SELECT T.*, TN.task_status
        FROM tasks T
        LEFT JOIN task_notification TN ON T.id = TN.task_id
        WHERE T.user_id = ?
        ORDER BY T.end_date ASC
';

if ($stmt = $connect->prepare($sql)) {
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
} else {
    echo "Error preparing statement: " . $connect->error;
}
?>

<div class="container">
    <div class="add-task my-4 d-flex justify-content-between align-items-center">

        <div>
            <a href="./add-new.php" class="btn btn-primary">Add New</a>
        </div>

    </div>

    <table width="100%" class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th class="text-start">Title</th>
                <th>Area</th>
                <th>Stages</th>
                <th>Start Date</th>
                <th>Due Date</th>
                <th>Labor Cost</th>
                <th>Progress</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0) {
                $count = 1;
            ?>

                <?php while ($item = $result->fetch_assoc()) {
                    $start = new DateTime($item['start_date']);
                    $end = new DateTime($item['end_date']);
                    $currentDate = new DateTime();
                    $total_duration = $start->diff($end)->days;
                    $elapsed_duration = $currentDate >= $start ? $start->diff($currentDate)->days + 1 : 0;
                    $progress_percentage = $total_duration > 0 ? min(100, ($elapsed_duration / $total_duration) * 100) : 0;
                    $formatted_percentage = number_format($progress_percentage);

                    echo '<tr>
                    <td>' . $count . '</td>
                    <td class="title text-start" data-title="' . htmlspecialchars($item['title']) . '">' . $item['title'] . '</td>
                    <td style="background-color: ' . ($item['area'] == 'Design' ? "#56a8ff" : '#9d0000') . ';" class="text-white">' . $item['area'] . '</td>
                    <td style="background-color: ' . ($item['stage'] == 'Meeting with Dev' ? "#9d0000" : '#56a8ff') . ';" class="text-white">' . $item['stage'] . '</td>
                    <td>' . $start->format('d-m-Y') . '</td>
                    <td style="color:' . ($total_duration <= 2 ? 'red' : 'green') . ';">' . $end->format('d-m-Y') . '
                        <i role="button" class="fa-solid fa-circle-info" data-bs-toggle="tooltip" data-bs-placement="top" title="You have ' . $total_duration . ' days left"></i>
                    </td>
                    <td>$' . $item['labor_cost'] . '</td>
                    <td>
                        <div class="progress position-relative" role="progressbar" aria-label="Basic example" aria-valuenow="' . $formatted_percentage . '" aria-valuemin="0" aria-valuemax="100">
                            <span class="position-absolute w-100 text-center">' . $formatted_percentage . '%</span>
                            <div class="progress-bar" style="width:' . $formatted_percentage . '%"></div>
                        </div>
                    </td>
                   <td>' .
                        ($item['task_status'] == 'Complete' ?
                            '
                            <a href="task-details.php?id=' . $item['id'] . '"><i class="fa-solid fa-eye"></i></a>
                            <i class="fa-solid fa-circle-check text-success"></i>
                           <i  data-id="' . $item['id'] . '" data-title="' . $item['title'] . '" class="title fa-solid fa-trash deleteTasks" data-bs-toggle="modal" data-bs-target="#staticBackdrop"></i>
                            ' :
                            '<a href="edit.php?id=' . $item['id'] . '"><i class="fa-solid fa-pen-to-square"></i></a>
                            <i  data-id="' . $item['id'] . '" data-title="' . $item['title'] . '" class="title fa-solid fa-trash deleteTasks" data-bs-toggle="modal" data-bs-target="#staticBackdrop"></i> '
                    ) .
                        '</td>

                </tr>';

                    $count++;
                } ?>
            <?php } else { ?>
                <tr>
                    <td class="text-center" colspan="9">No Tasks Available</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete Task</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class='text-dark'>Are you sure to delete? <span class="modal-data text-danger"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">No</button>
                <button type="button" id="confirmDelete" class="btn btn-success">Yes</button>
            </div>
        </div>
    </div>
</div>

<?php
include('./include/footer.php');
?>


<script>
    $(document).ready(function() {
        let taskID;

        // Trigger delete modal
        $(".deleteTasks").on('click', function() {
            taskID = $(this).attr("data-id");
            taskTitle = $(this).attr("data-title");
            $(".modal-data").text(`${taskTitle}`);
        });

        // Handle delete confirmation
        $("#confirmDelete").on('click', function() {
            $.ajax({
                url: 'delete-action.php',
                type: 'POST',
                data: {
                    id: taskID
                },
                success: function(response) {
                    let result = JSON.parse(response);
                    if (result.status) {
                        console.log('Task deleted successfully');
                        location.reload();
                    } else {
                        console.log('Failed to delete task');
                    }
                },
                error: function() {
                    console.log('Error in request');
                }
            });
        });
    });
</script>