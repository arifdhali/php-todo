<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>


    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/smoothness/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./public/css/style.min.css">
</head>

<body>
    <?php
    session_start();
    $user_name = $_SESSION['user_name'] ?? null;
    $user_img =  $_SESSION['user_image'] ?? null;

    ?>
    <div class="container pb-5 pt-3">
        <div class="row align-items-center justify-content-between">
            <div class="col-md-6 ">
                <h2><?= $user_name ?></h2>
                
            </div>
            <div class="col-md-6 text-end d-flex align-items-center justify-content-end">
                <img src="<?= $user_img  ?>" alt="<?= $user_name ?>" class="user_img">
                <button class="btn btn-warning ms-4" id="logout">Log out</button>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#logout").on("click", function() {
                let confirmation = confirm("Are you sure you want to log out?");
                if (confirmation) {
                    $.ajax({
                        url: "logout-action.php",
                        method: "POST",
                        data: {
                            _method: 'DELETE'
                        },
                        success: function(res) {
                            res = JSON.parse(res);
                            if (res.status) {
                                $(location).attr('href', 'login.php');
                            } else {
                                alert(res.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error:", error);
                        }
                    });
                }
            });
        });
    </script>