<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
}



// Code for page goes here


if (isset($_GET["course_id"]) && isset($_GET["unit_id"]) && isset($_GET["quiz_id"])) {
    $course_id = $_GET["course_id"];
    $unit_id = $_GET["unit_id"];
    $quiz_id = $_GET["quiz_id"];
    $instructions_link = "instructions.php?course_id=$course_id&unit_id=$unit_id&quiz_id=$quiz_id";
} else {
    header("location: courses.php");
}

require "db_connect.php";

$sql = "SELECT * FROM quizzes WHERE quiz_id = $quiz_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        $quiz_id = $row["quiz_id"];
        $quiz_name = $row["quiz_name"];
        $quiz_desc = $row["quiz_desc"];
        $quiz_tip = $row["quiz_tip"];
        $quiz_tip_timer = $row["quiz_tip_timer"];
        $quiz_question_total = $row["quiz_question_total"];
    }
} else {
    echo "0 results";
}

if (isset($_POST["instructions"])) {


    $user_id = $_SESSION["user_id"];

    $sql = "INSERT INTO `attempts` (`attempt_id`, `attempt_time_elapsed`, `attempt_date`, `attempt_score`, `attempt_credits`, `quiz_id`, `user_id`)
     VALUES (NULL, '', CURRENT_TIMESTAMP, '0', '0', '$quiz_id', '$user_id');";

    if (mysqli_query($conn, $sql)) {

        $attempt_id = mysqli_insert_id($conn);
        $_SESSION["course_id"] = $course_id;
        $_SESSION["unit_id"] = $unit_id;
        $_SESSION["quiz_id"] = $quiz_id;
        $_SESSION["quiz_name"] = $quiz_name;
        $_SESSION["quiz_tip"] = $quiz_tip;
        $_SESSION["quiz_tip_timer"] = $quiz_tip_timer;
        $_SESSION["attempt_id"] = $attempt_id;
        $_SESSION["attempt_score"] = 0;
        $_SESSION["quiz_question_total"] = $quiz_question_total;
        $_SESSION["quiz_question_num"] = 1;
        $_SESSION["question_credits"] = 0;
        $_SESSION["attempt_credits"] = 0;



        header("location: quiz.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
$page_title = "$quiz_name Instructions";

include "header.php";
?>
<!-- page specific styling goes here -->

<?php include "navbar.php"; ?>

<!-- content for the page starts here -->

<h3> <?php echo $quiz_name; ?></h3>
<div> <?php echo $quiz_desc; ?></div>



<?php

//display previous result

require "custom_functions.php";

$user_id = $_SESSION["user_id"];

$sql = "SELECT * FROM attempts, quizzes WHERE attempts.quiz_id = quizzes.quiz_id AND attempts.quiz_id = $quiz_id AND attempts.user_id = $user_id ORDER BY attempt_date DESC LIMIT 1";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        $attempt_time_elapsed = $row["attempt_time_elapsed"];
        $attempt_date = get_time_ago(strtotime($row["attempt_date"]));
        $attempt_score = $row["attempt_score"];
        $attempt_credits = $row["attempt_credits"];
        $quiz_question_total = $row["quiz_question_total"];
    }

    ?>

<div>You last attempted this quiz <?php echo $attempt_date; ?></div>
<div>Time elapsed - <?php echo $attempt_time_elapsed; ?></div>
<div>Score achieved - <?php echo $attempt_score; ?> out of <?php echo $quiz_question_total; ?> </div>
<div>Credits earned - <?php echo $attempt_credits; ?></div>

<?php
} else {
    ?>

<div>You have not yet attempted this quiz. Good Luck!</div>

<?php
}


?>

<form action="<?php echo $instructions_link; ?>" method="post">
    <input class="btn btn-primary btn-lg" type="submit" value="Begin Quiz" name="instructions">
</form>