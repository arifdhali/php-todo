<?php
include("./db/config.php");

?>
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
<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-dark text-white" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">

                        <div class="pb-3">
                            <h2 class="fw-bold mb-4 ">Create new account</h2>
                            <form action="signup-action.php" method="POST" class="form">
                                <div class="form-outline form-white mb-4 profile-image">
                                    <label class="form-label text-start">Profile image</label>
                                    <div class="input-group mb-3">
                                        <input type="file" class="form-control" name="profile_img" id="profile_img">
                                        <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                    </div>
                                    <div class="mx-auto mb-3">
                                        <img id="preview_img" src="" alt="Profile image">
                                    </div>

                                    <p class="mt-1 error error-profile text-danger fs-6 text-start"></p>
                                </div>
                                <div class="form-outline form-white mb-4">
                                    <label class="form-label text-start" for="username">User name</label>
                                    <input placeholder="Enter username" type="text" id="username" name="username" class="form-control form-control-lg" />
                                    <p class="mt-1 error error-username text-danger fs-6 text-start"></p>

                                </div>
                                <div class="form-outline form-white mb-4">
                                    <label class="form-label text-start" for="usermobile">Mobile</label>
                                    <input  placeholder="Enter mobile" type="tel" id="usermobile" name="mobile" class="form-control form-control-lg" maxlength="15" minlength="10" />
                                    <p class="mt-1 error error-mobile text-danger fs-6 text-start"></p>
                                </div>
                                <div class="form-outline form-white mb-4">
                                    <label class="form-label text-start" for="typeEmailX">Email</label>
                                    <input  placeholder="Enter email" type="text" id="typeEmailX" name="email" class="form-control form-control-lg" />
                                    <p class="mt-1 error error-email text-danger fs-6 text-start"></p>
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <label class="form-label text-start"   for="typePasswordX">Password</label>
                                    <div class="position-relative">
                                        <input type="password" id="typePasswordX" placeholder="Enter password" name="password" class="form-control form-control-lg" />
                                        <i class="text-center password-check fa-regular fa-eye-slash position-absolute top-50 translate-middle text-dark" style="right: 8px;" role="button"></i>
                                    </div>
                                    <p class="mt-1 error error-password text-danger fs-6 text-start"></p>
                                </div>

                                <hr>
                                <button class="btn btn-outline-light btn-lg px-5" type="submit">Sign up</button>
                            </form>
                        </div>

                        <div>
                            <p class="mb-0">Already have an account? <a href="login.php" class="text-white-50 fw-bold">Login</a></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        $("#usermobile").on('input', function(e) {
            const value = e.target.value;
            let numberFormat = /^[0-9]+$/;
            if (!numberFormat.test(value)) {
                $(".error-mobile").html('Mobile number must contain only digits.');
            } else if (value.length < 10 || value.length > 15) {
                $(".error-mobile").html('Mobile number must be between 10 and 15 digits.');
            } else {
                $(".error-mobile").html('');
            }
        });
        let profileImgInput = $("#profile_img");
        let previewImg = $("#preview_img");

        profileImgInput.on("change", function(e) {
            const file = e.target.files[0];

            const reader = new FileReader();

            reader.addEventListener("load", function() {
                previewImg.attr("src", reader.result);
            });

            if (file) {
                reader.readAsDataURL(file);
                $(".upload-btn").css("display", "none");
            } else {
                console.log('please upload a file');
                $(".upload-btn").css("display", "block");
            }
        });



        var passwordInput = $('#typePasswordX');
        $(".password-check").on("click", function() {
            passwordInput.attr('type', passwordInput.attr('type') === 'password' ? 'text' : 'password');
            $(this).toggleClass('fa-eye fa-eye-slash');
        })
        // Form submission
        $('.form').on('submit', function(e) {
            e.preventDefault();
            let formD = new FormData(this);
            $.ajax({
                url: "signup-action.php",
                method: 'POST',
                data: formD,
                contentType: false,
                processData: false,
                success: function(response) {
                    var response = JSON.parse(response);
                    $(`.error`).html('');
                    console.log(response);
                    if (response.status) {
                        $(location).attr('href', 'login.php');
                        $(".form")[0].reset();
                    } else {
                        Object.entries(response.msg).forEach(([key, value]) => {
                            $(`.error-${key}`).html(value);
                        });
                    }


                }
            })



        })

    });
</script>