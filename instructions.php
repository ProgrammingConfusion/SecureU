<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
}

$page_title = "Quiz Instructions";

// Code for page goes here

if (isset($_POST["instructions"])) {

    require "db_connect.php";

    $user_id = $_SESSION["user_id"];
    $quiz_id = 1;

    $sql = "INSERT INTO `attempts` (`attempt_id`, `attempt_time_elapsed`, `attempt_date`, `attempt_score`, `attempt_credits`, `quiz_id`, `user_id`)
     VALUES (NULL, '', CURRENT_TIMESTAMP, '0', '0', '$quiz_id', '$user_id');";

    if (mysqli_query($conn, $sql)) {
        header("location: quiz.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

include "header.php";
?>
<!-- page specific styling goes here -->

<?php include "navbar.php"; ?>

<!-- content for the page starts here -->
<form action="instructions.php" method="post">
    <input class="btn btn-primary btn-lg" type="submit" name="instructions">
</form>