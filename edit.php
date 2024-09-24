<?php
include('./include/header.php');
include('./db/config.php');

include "./helpers/session_managment.php";
redirectToCorrectPage();
$taskID = null;
if (isset($_GET['id'])) {
    $taskID = $_GET['id'];
    $sql = "SELECT title, area, stage, start_date, end_date, labor_cost FROM tasks WHERE id = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("i", $taskID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $task = $result->fetch_assoc();
    } else {
        echo "Task not found.";
        exit;
    }
} else {
    echo "No ID provided.";
    exit;
}
?>

<div class="container">
    <div class="my-5">
        <a href="http://arif/php/todo/">Home</a>
    </div>
    <form class="form" method="POST">
        <div class="mb-3">
            <label class="mb-1" for="title">Title</label>
            <input id="title" class="form-control" type="text" name="title" value="<?= $task['title'] ?>">
            <label id="error-title" class="error"></label>
        </div>
        <div class="mb-3">
            <label class="mb-1" for="area">Area</label>
            <select name="area" id="area">
                <option value="<?= $task['area'] ?>" selected><?= $task['area'] ?></option>
                <!-- <option value="Development">Development</option> -->
            </select>
            <label id="error-area" class="error"></label>
        </div>
        <div class="mb-3">
            <label class="mb-1" for="stage">Stage</label>
            <select name="stage" id="stage">
                <option value="<?= $task['stage'] ?>" selected><?= $task['stage'] ?></option>
                <!-- <option value="Meeting with Dev">Meeting with Dev</option> -->
            </select>
            <label id="error-stage" class="error"></label>
        </div>
        <div class="mb-3">
            <label class="mb-1" for="startDate">Start Date</label>
            <input id="startDate" name="start_date" class="form-control" type="text" value="<?= $task['start_date'] ?>" readonly disabled>
            <label id="error-start_date" class="error"></label>
        </div>
        <div class="mb-3">
            <label class="mb-1" for="endDate">End Date</label>
            <input id="endDate" name="end_date" class="form-control" type="text" value="<?= $task['end_date'] ?>">
            <label id="error-end_date" class="error"></label>
        </div>
        <div class="mb-3">
            <label class="mb-1" for="laborCost">Labor Cost</label>
            <input id="laborCost" name="labor_cost" class="form-control" type="text" value="<?= $task['labor_cost'] ?>">
            <label id="error-labor_cost" class="error"></label>
        </div>
        <div>
            <input type="hidden" name="task_id" value="<?= $taskID ?>">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#stage,#area').select2();
        $("#endDate").datepicker({
            gotoCurrent: true,
            minDate: new Date(),
            dateFormat: "yy-mm-dd"
        });


        // Form submission
        $(".form").on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: 'edit-action.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    response = JSON.parse(response);
                    $(".error").html("");
                    if (response.success) {
                        $(location).attr('href', 'index.php');                        

                    } else {
                        Object.entries(response.message).forEach(([key, value]) => {
                            $(`#error-${key}`).html(value);
                        });
                    }
                }
            });
        });
    });
</script>

<?php
include('./include/footer.php');
?>