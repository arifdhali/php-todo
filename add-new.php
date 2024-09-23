<?php
include('./include/header.php');

?>

<div class="container">
    <div class="my-5">
        <a href="http://arif/php/todo/">Home</a> 
    </div>
    <form class="form" action="add-new-action.php" method="POST">
        <div class="mb-3">
            <label class="mb-1" for="title">Title</label>
            <input id="title" class="form-control" type="text" name="title">
            <label id="error-title" class="error"></label>
        </div>
        <div class="mb-3">
            <label class="mb-1" for="area">Area</label>
            <select name="area" id="area">
                <option value="Design">Design</option>
                <option value="Development">Development</option>
            </select>
            <label id="error-area" class="error"></label>
        </div>
        <div class="mb-3">
            <label class="mb-1" for="stage">Stage</label>
            <select name="stage" id="stage">
                <option value="Planning & Costing">Planning & Costing</option>
                <option value="Meeting with Dev">Meeting with Dev</option>
            </select>
            <label id="error-stage" class="error"></label>
        </div>
        <div class="mb-3">
            <label class="mb-1" for="startDate">Start Date</label>
            <input id="startDate" name="start_date" class="form-control" type="text">
            <label id="error-start_date" class="error"></label>
        </div>
        <div class="mb-3">
            <label class="mb-1" for="endDate">End Date</label>
            <input id="endDate" name="end_date" class="form-control" type="text">
            <label id="error-end_date" class="error"></label>
        </div>
        <div class="mb-3">
            <label class="mb-1" for="laborCost">Labor Cost</label>
            <input id="laborCost" name="labor_cost" class="form-control" type="text">
            <label id="error-labor_cost" class="error"></label>
        </div>
        <div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('#stage,#area').select2();
        $("#startDate,#endDate").datepicker({
            gotoCurrent: true,
            minDate: new Date(),
            dateFormat: "yy-mm-dd"
        });

        // Form submission
        $(".form").on('submit', function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: 'add-new-action.php',
                type: 'POST',
                data: formData,
                success: function (response) {
                    response = JSON.parse(response);
                    $(".error").html("");
                    if (response.success) {
                        $(location).attr('href', 'index.php');                        
                        $(".form")[0].reset();
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