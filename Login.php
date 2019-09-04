<?php

$page_title = 'Login';

$error = "9";

if (isset($_POST["login"])) {
    require "db_connect.php";

    $email = mysqli_real_escape_string($conn, trim($_POST["email"]));
    $password = mysqli_real_escape_string($conn, trim($_POST["password"]));

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {

            $db_password = $row["password"];

            if (password_verify($password, $db_password)) {
                $error = "0";

                session_start();
                $_SESSION["user_id"] = $row["user_id"];
                $_SESSION["first_name"] = $row["first_name"];
                $_SESSION["last_name"] = $row["last_name"];
                $_SESSION["username"] = $row["username"];
                $_SESSION["email"] = $row["email"];
                $_SESSION["user_role"] = $row["user_role"];
                header("location: homepage.php");
            } else {
                $error = "1";
            }
        }
    } else {
        $error = "2";
    }
}

include "header.php";

?>

<?php include "navbar.php"; ?>

<!-- content for the page starts here -->



<div class="container">
    <div class="row">
        <div class="col-md-6 col-lg-6 mx-auto">
            <?php if ($error == 1) {
                ?>
            <div class="alert alert-danger" role="alert">
                Please enter the correct password.
            </div>
            <?php

            }
            ?>

            <?php if ($error == 0) {
                ?>
            <div class="alert alert-success" role="alert">
                Login Successful.
            </div>
            <?php

            }
            ?>

            <?php if ($error == 2) {
                ?>
            <div class="alert alert-danger" role="alert">
                There is no account with that email, please register an account.
            </div>
            <?php

            }
            ?>
            <h1>Log in</h1>
            <br>
            <div class="registration mx-auto d-block w-100">
                <form action="Login.php" method="post">
                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" class="form-control" placeholder="Enter your email" name="email" id="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password *</label>
                        <input type="password" class="form-control" placeholder="Enter your password" name="password" id="password" required>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="form-group d-flex justify-content-start">
                            <input type="submit" class="btn btn-primary" name="login" value="Login">
                        </div>

                        <div class="form-check form-group d-flex justify-content-center">
                            <a class="btn btn-primary" href="registration.php">Register instead</a>
                        </div>
                        <?php
                        include "redirect.php"; ?>

                    </div>
            </div>
        </div>
    </div>



    <?php include "footer.php"; ?>