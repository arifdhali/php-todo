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
    include("./db/config.php");
    include("./helpers/session_managment.php");
    session_start();

    ?>

    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <div class="pb-5">
                                <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                                <p class="text-danger mb-5 error" id="alert-msg"></p>

                                <form method="POST" class="form">
                                    <div class="form-outline form-white mb-4">
                                        <label class="form-label text-start" for="typeEmailX">Email</label>
                                        <input type="email" id="typeEmailX" name="email" class="form-control form-control-lg" />
                                        <p class="mt-1 error error-email text-danger fs-6 text-start"></p>
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <label class="form-label text-start" for="typePasswordX">Password</label>
                                        <input type="password" id="typePasswordX" name="password" class="form-control form-control-lg" />
                                        <p class="mt-1 error error-password text-danger fs-6 text-start"></p>
                                    </div>
                                    <button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>
                                </form>
                            </div>

                            <div>
                                <p class="mb-0">Don't have an account? <a href="signup.php" class="text-white-50 fw-bold">Sign Up</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {
            // Form submission
            $(".form").on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: 'login-action.php',
                    type: 'POST',
                    data: formData,
                    success: function(res) {
                        res = JSON.parse(res);
                        $(`.error`).html('');
                        $("#alert-msg").html(res.message)
                        if (res.status) {
                            $(location).attr("href", res.redirect);
                            $(".form")[0].reset();
                        } else {
                            Object.entries(res.message).forEach(([key, value]) => {
                                $(`.error-${key}`).html(value);
                            })
                        }
                    }
                });
            });
        });
    </script>