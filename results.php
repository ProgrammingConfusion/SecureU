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

    require "db_connect.php";

    $sql = "UPDATE `attempts` SET `attempt_score` = '$attempt_score'
     WHERE `attempts`.`attempt_id` = $attempt_id;";


    //unset session variables
    unset($_SESSION["attempt_score"]);
    unset($_SESSION["attempt_id"]);
    unset($_SESSION["quiz_question_num"]);
    unset($_SESSION["course_id"]);
    unset($_SESSION["unit_id"]);
    unset($_SESSION["quiz_id"]);


    if (mysqli_query($conn, $sql)) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

include "header.php";
?>
<!-- page specific styling goes here -->

<?php include "navbar.php"; ?>

<!-- content for the page starts here -->

<h1>Your final score is <?php echo $attempt_score; ?> </h1>