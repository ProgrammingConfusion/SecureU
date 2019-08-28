<?php

$page_title = 'Registration';



$error = "9";

if (isset($_POST["registration"])) {

    require "db_connect.php";


    $email = mysqli_real_escape_string($conn, trim($_POST["email"]));
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 0) {

        $username = mysqli_real_escape_string($conn, trim($_POST["username"]));
        $password = mysqli_real_escape_string($conn, trim($_POST["password"]));
        $password = password_hash($password, PASSWORD_DEFAULT);
        $first_name = mysqli_real_escape_string($conn, trim($_POST["first_name"]));
        $last_name = mysqli_real_escape_string($conn, trim($_POST["last_name"]));
        $date_of_birth = $_POST["date_of_birth"];
        $user_role = mysqli_real_escape_string($conn, trim($_POST["user_role"]));



        $sql = "INSERT INTO `users` (`user_id`, `email`, `username`, `password`, `first_name`, `last_name`, `user_dob`, `user_role`, `reg_date`)
         VALUES (NULL, '$email', '$username', '$password', '$first_name', '$last_name', '$date_of_birth', '$user_role', CURRENT_TIMESTAMP);";

        if (mysqli_query($conn, $sql)) {
            $error = 0;
        } else {
            $error = 2;
        }
    } else {
        $error = 1;
    }
}

include "header.php";
?>

<?php include "navbar.php"; ?>

<div class="container">
    <div class="row">
        <div class="col-md-6 col-lg-6 mx-auto">
            <?php if ($error == 1) {
                ?>
            <div class="alert alert-danger" role="alert">
                An account with this email address is already registered.
            </div>
            <?php

            }
            ?>

            <?php if ($error == 0) {
                ?>
            <div class="alert alert-success" role="alert">
                Registration Successful. Thank you for registering!
            </div>
            <?php

            }
            ?>

            <?php if ($error == 2) {
                ?>
            <div class="alert alert-danger" role="alert">
                Registration Failed.
            </div>
            <?php

            }
            ?>
            <div class="registration mx-auto d-block w-100">
                <div class="page-header text-center">
                    <h1>Sign up</h1>
                </div>

                <form action="registration.php" method="post" class="form-validate form-horizontal well">
                    <fieldset>
                        <legend>User Registration</legend>
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" class="form-control" placeholder="Enter your email" name="email" id="email" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Username *</label>
                            <input type="text" class="form-control" placeholder="Enter your username" name="username" id="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password *</label>
                            <input type="password" class="form-control" placeholder="Enter your password" name="password" id="password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password *</label>
                            <input type="password" class="form-control" placeholder="Confirm your password" name="confirm_password" id="confirm_password" required>
                        </div>
                        <div class="form-group">
                            <label for="first_name"> First Name *</label>
                            <input type="text" class="form-control" placeholder="Enter your first name" name="first_name" id="first_name" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name *</label>
                            <input type="text" class="form-control" placeholder="Enter your last name" name="last_name" id="last_name" required>
                        </div>
                        <div class="form-group">
                            <label for="">Date of Birth*</label>
                            <input type="date" name="date_of_birth" placeholder="Enter your date of birth" class="form-control" required> <br>
                        </div>
                        <div>I am a:</div>
                        <div class="custom-control custom-radio form-check-inline">
                            <input type="radio" id="Student" name="user_role" value="Student" class="custom-control-input" required>
                            <label class="custom-control-label" for="Student">Student</label>
                        </div>
                        <div class="custom-control custom-radio form-check-inline">
                            <input type="radio" id="Tutor" name="user_role" value="Tutor" class="custom-control-input">
                            <label class="custom-control-label" for="Tutor">Tutor</label>
                        </div>
                        <br>
                        <br>

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="form-group d-flex justify-content-start">
                                <input type="submit" class="btn btn-primary" name="registration" value="Register">
                            </div>

                            <div class="form-check form-group d-flex justify-content-center">
                                <a class="btn btn-primary" href="login.php">Login instead</a>
                            </div>
                            <?php
                            include "redirect.php"; ?>
                    </fieldset>
            </div>

            </form>
        </div>

    </div>





</div>
</div>






<!-- Script to validate if password and confirm password fields are the same -->
<script>
    var password = document.getElementById("password"),
        confirm_password = document.getElementById("confirm_password");

    function validatePassword() {
        if (password.value != confirm_password.value) {
            confirm_password.setCustomValidity("Passwords Don't Match");
        } else {
            confirm_password.setCustomValidity('');
        }
    }

    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;
</script>