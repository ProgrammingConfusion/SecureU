<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
}

$page_title = "Quiz Results";

// Code for page goes here

if (isset($_SESSION["attempt_score"])) {
    $attempt_score = $_SESSION["attempt_score"];
    $attempt_id = $_SESSION["attempt_id"];
    $attempt_credits = $_SESSION["attempt_credits"];
    $quiz_question_total = $_SESSION["quiz_question_total"];


    require "db_connect.php";

    $sql = "UPDATE `attempts` SET `attempt_score` = '$attempt_score', `attempt_credits` = '$attempt_credits' 
    WHERE `attempts`.`attempt_id` = $attempt_id;";


    //unset session variables
    unset($_SESSION["attempt_score"]);
    unset($_SESSION["attempt_credits"]);
    unset($_SESSION["attempt_id"]);
    unset($_SESSION["quiz_question_num"]);
    unset($_SESSION["quiz_question_total"]);
    unset($_SESSION["quiz_id"]);


    if (mysqli_query($conn, $sql)) {
        echo "Record updated successfully";

        $user_id = $_SESSION["user_id"];

        $sql = "UPDATE `users` SET `user_credits` = $attempt_credits + user_credits WHERE `users`.`user_id` = $user_id;";

        if (mysqli_query($conn, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
} else {
    header("location: courses.php");
}

include "header.php";
?>
<!-- page specific styling goes here -->

<?php include "navbar.php"; ?>

<!-- content for the page starts here -->
<div class="container">
    <h1>Results</h1>
    <div class="card">
        <h5 class="card-title card-header">Here are your results!</h5>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Your final score is <?php echo $attempt_score; ?> out of <?php echo $quiz_question_total; ?></li>
            <li class="list-group-item">Credits earned: <?php echo $attempt_credits; ?></li>
            <li class="list-group-item"><a href="courses.php" class="btn btn-primary">Back to Courses</a></li>
        </ul>

    </div>
</div>