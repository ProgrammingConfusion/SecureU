<?php

$page_title = 'Login';

session_start();

if (isset($_POST["login"])) {
    require "db_connect.php";

    $username = mysqli_real_escape_string($conn, trim($_POST["username"]));
    $password = mysqli_real_escape_string($conn, trim($_POST["password"]));

    $sql = "SELECT * FROM users WHERE username ='$username'";
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
        echo "No account with that username exists.";
    }
}

include "header.php";

?>

<form action="Login.php" method="post">

    Username <br>
    <input type="text" name="username" placeholder="Enter your Username"> <br>
    <br>
    Password <br>
    <input type="password" name="password" placeholder="Enter your Password"> <br>

    <input type="submit" name="login" value="Log in">


</form>




<?php include "footer.php"; ?>