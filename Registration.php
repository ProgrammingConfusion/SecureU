<?php

$page_title = 'Registration';



$error = 0;

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
            $error = 2;
        } else {
            $error = 3;
        }
    } else {
        $error = 1;
    }
}

include "header.php";
?>

<?php include "navbar.php"; ?>

<h1>Registration</h1>

<form action="registration.php" method="post">

    Email <br>
    <input type="email" name="email"> <br>

    Username <br>
    <input type="text" name="username"><br>

    Password <br>
    <input type="password" name="password" id="password"><br>

    Confirm Password <br>
    <input type="password" name="confirm_password" id="confirm_password"><br>

    First Name <br>
    <input type="text" name="first_name"><br>

    Last Name <br>
    <input type="text" name="last_name"><br>

    Date of Birth <br>
    <input type="date" name="date_of_birth"><br>
    <br>


    Register as a
    <select name="user_role">
        <option value="student">Student</option>
        <option value="teacher">Teacher</option>
    </select><br>
    <br>


    <input type="submit" name="registration" value="Register">

    <?php
    include "redirect.php"; ?>

    <?php if ($error == 1) {
        ?>
    <div class="alert alert-danger" role="alert">
        An account with this email address is already registered.
        <?php

        }
        ?>

        <?php if ($error == 2) {
            ?>
        <div class="alert alert-success" role="alert">
            Registration Successful. Thank you for registering!
            <?php

            }
            ?>

            <?php if ($error == 3) {
                ?>
            <div class="alert alert-danger" role="alert">
                Registration Failed.
                <?php

                }
                ?>
</form>

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