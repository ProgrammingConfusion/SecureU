<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
}

$page_title = "Create Exercises";

// Code for page goes here

if (isset($_POST["add_quiz"])) {

    require "db_connect.php";


    $unit_id = mysqli_real_escape_string($conn, trim($_POST["unit_id"]));
    $quiz_name = mysqli_real_escape_string($conn, trim($_POST["quiz_name"]));
    $quiz_desc = mysqli_real_escape_string($conn, trim($_POST["quiz_desc"]));
    $quiz_tip = mysqli_real_escape_string($conn, trim($_POST["quiz_tip"]));
    $user_id = $_SESSION["user_id"];



    $sql = "INSERT INTO `quizzes` (`quiz_id`, `quiz_name`, `quiz_desc`, `quiz_tip`, `quiz_question_total`, `quiz_credits`, `unit_id`, `user_id`) 
    VALUES (NULL, '$quiz_name', '$quiz_desc', '$quiz_tip', '0', '0', '$unit_id', '$user_id');";

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

include "header.php";
?>
<!-- page specific styling goes here -->

<?php include "navbar.php"; ?>

<!-- content for the page starts here -->
<form action="add_exercises.php" method="post">
    Select a Unit<br>
    <select name="unit_id" placeholder="Select a Unit ">
        <?php

        require "db_connect.php";

        $user_id = $_SESSION["user_id"];

        $sql = "SELECT * FROM units, courses WHERE units.course_id = courses.course_id AND courses.user_id = $user_id";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while ($row = mysqli_fetch_assoc($result)) {

                $unit_id = $row["unit_id"];
                $unit_name = $row["unit_name"];
                $course_name = $row["course_name"];

                ?>
                <option value="<?php echo $unit_id ?>"><?php echo "$course_name - $unit_name" ?></option>

            <?php
            }
        }

        ?>

    </select> <br>
    <br>


    Quiz Name <br>
    <input type="text" name="quiz_name" placeholder="Enter Unit Name"> <br>
    <br>



    Quiz Description <br>
    <input type="text" name="quiz_desc" placeholder="Enter Quiz Description"> <br>
    <br>


    Quiz Tip <br>
    <input type="text" name="quiz_tip" placeholder="Enter Quiz Tip"> <br>
    <br>


    <input type="submit" name="add_quiz" value="Create Quiz">




</form>