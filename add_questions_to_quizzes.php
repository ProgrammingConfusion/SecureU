<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
}

$page_title = "Add Questions";

// Code for page goes here

if (isset($_POST["add_questions"])) {

    require "db_connect.php";


    $quiz_id = mysqli_real_escape_string($conn, trim($_POST["quiz_id"]));
    $question_content = mysqli_real_escape_string($conn, trim($_POST["question_content"]));
    $answer_content = mysqli_real_escape_string($conn, trim($_POST["answer_content"]));
    $question_type = mysqli_real_escape_string($conn, trim($_POST["question_type"]));
    $answer_a = mysqli_real_escape_string($conn, trim($_POST["answer_a"]));
    $answer_b = mysqli_real_escape_string($conn, trim($_POST["answer_b"]));
    $answer_c = mysqli_real_escape_string($conn, trim($_POST["answer_c"]));
    $answer_d = mysqli_real_escape_string($conn, trim($_POST["answer_d"]));
    $user_id = $_SESSION["user_id"];





    //query to add questions to database


    $sql = "INSERT INTO `questions` (`question_id`, `question_type`, `question_content`, `answer_content`, `answer_a`, `answer_b`, `answer_c`, `answer_d`, `user_id`) 
    VALUES (NULL, ' $question_type', '$question_content', '$answer_content', '$answer_a', '$answer_b', '$answer_c', '$answer_d', '$user_id');";



    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";

        //using get last to get back question_id of the question that was just inserted

        $question_id = mysqli_insert_id($conn);

        $sql = "INSERT INTO `quiz_questions` (`quiz_question_id`, `quiz_question_num`, `quiz_id`, `question_id`) 
        VALUES (NULL, '1', '$quiz_id', '$question_id');";

        if (mysqli_query($conn, $sql)) {
            echo "New record created successfully";

            $sql = "UPDATE `quizzes` SET `quiz_question_total` = 
            (SELECT COUNT(*) FROM quiz_questions WHERE quiz_questions.quiz_id = $quiz_id) WHERE `quizzes`.`quiz_id` = $quiz_id;";

            if (mysqli_query($conn, $sql)) {
                echo "Record updated successfully";
            } else {
                echo "Error updating record: " . mysqli_error($conn);
            }
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

include "header.php";
?>
<!-- page specific styling goes here -->

<!-- <?php include "navbar.php"; ?> -->

<!-- content for the page starts here -->

<form action="add_questions_to_quizzes.php" method="post">



    Select a quiz <br>
    <select name="quiz_id" placeholder="Select A Quiz To Add Questions">
        <?php

        require "db_connect.php";

        $user_id = $_SESSION["user_id"];

        $sql = "SELECT * FROM quizzes, units, courses WHERE quizzes.unit_id = units.unit_id AND units.course_id = courses.course_id AND quizzes.user_id = $user_id";
        echo $sql;

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while ($row = mysqli_fetch_assoc($result)) {

                $quiz_id = $row["quiz_id"];

                $quiz_name = $row["quiz_name"];
                $course_name = $row["course_name"];

                ?>
        <option value="<?php echo "$quiz_id" ?>"><?php echo "$course_name - $quiz_name" ?></option>

        <?php
            }
        }

        ?>



    </select>
    <br>
    <br>

    Question<br>
    <input type="text" name="question_content" placeholder="Enter Question Content"> <br>
    <br>


    Answer<br>
    <input type="text" name="answer_content" placeholder="Enter Answer Content"> <br>
    <br>

    Question type <br>
    <select name="question_type" placeholder="Enter Question Type">
        <option value="Multiple Choice">Multiple Choice</option>
        <option value="True or False">True or False</option>
        <option value="Fill in the blank">Fill in the blank</option>


    </select>
    <br>
    <br>


    Answer A<br>
    <input type="text" name="answer_a" placeholder="Enter Answer A"> <br>
    <br>

    Answer B<br>
    <input type="text" name="answer_b" placeholder="Enter Answer B"> <br>
    <br>

    Answer C<br>
    <input type="text" name="answer_c" placeholder="Enter Answer C"> <br>
    <br>

    Answer D<br>
    <input type="text" name="answer_d" placeholder="Enter Answer D"> <br>
    <br>

    <input type="submit" name="add_questions" value="Create Question">




</form>