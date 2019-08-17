<?php

$page_title = 'Login';

session_start();

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
                echo "Successful Login";

                $_SESSION["user_id"] = $row["user_id"];
                $_SESSION["first_name"] = $row["first_name"];
                $_SESSION["last_name"] = $row["last_name"];
                $_SESSION["username"] = $row["username"];
                $_SESSION["email"] = $row["email"];
                $_SESSION["user_role"] = $row["user_role"];
                header("location: homepage.php");
            } else {
                echo "Incorrect login credentials";
            }
        }
    } else {
        echo "No account with that email address exists.";
    }
}

include "header.php";

?>

<?php include "navbar.php"; ?>

<!-- content for the page starts here -->


<div class="container" style="margin-top: 100px">
    <div class="row justify-content-center">
        <div class="col-md-6 col-offset-3" align="center">

            <form action="Login.php" method="post">
                <input placeholder="Email..." name="email" class="form-control"><br>
                <input type="password" placeholder="Password..." name="password" class="form-control"><br>
                <input type="submit" name="login" value="Log In" class="btn btn-primary">
                <input type="button" value="Log In With Google" class="btn btn-danger">
            </form>

        </div>
    </div>
</div>



<?php include "footer.php"; ?>