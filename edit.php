<?php
include('./include/header.php');
include('./db/config.php');

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
    <div class="my-5 d-flex justify-content-between w-100">
        <a href="http://arif/php/todo/">Home</a>
        <form method="POST" class="send_id">
            <input type="hidden" name="task_id" value="<?php echo $taskID; ?>">
            <input type="hidden" id="dateTime" name="task_c_date">
            <button class="btn btn-success" type="submit">Complete Task</button>
        </form>

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
            </select>
            <label id="error-area" class="error"></label>
        </div>
        <div class="mb-3">
            <label class="mb-1" for="stage">Stage</label>
            <select name="stage" id="stage">
                <option value="<?= $task['stage'] ?>" selected><?= $task['stage'] ?></option>
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
        let dateT = $("#dateTime");

        setInterval(() => {
            let now = new Date();
            let year = now.getFullYear();
            let month = String(now.getMonth() + 1).padStart(2, '0');
            let day = String(now.getDate()).padStart(2, '0');
            let hours = String(now.getHours()).padStart(2, '0');
            let minutes = String(now.getMinutes()).padStart(2, '0');
            let seconds = String(now.getSeconds()).padStart(2, '0');
            let localTime = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
            dateT.val(localTime);
        }, 0)

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
        $(".send_id").on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: 'task-notification.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status) {
                        $(location).attr('href', 'index.php');
                    }

                }
            });
        });

    });
</script>

<?php
include('./include/footer.php');
?>