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
    $question_credits = mysqli_real_escape_string($conn, trim($_POST["question_credits"]));
    $question_type = mysqli_real_escape_string($conn, trim($_POST["question_type"]));
    $answer_a = mysqli_real_escape_string($conn, trim($_POST["answer_a"]));
    $answer_b = mysqli_real_escape_string($conn, trim($_POST["answer_b"]));
    $answer_c = mysqli_real_escape_string($conn, trim($_POST["answer_c"]));
    $answer_d = mysqli_real_escape_string($conn, trim($_POST["answer_d"]));
    $user_id = $_SESSION["user_id"];





    //query to add questions to database


    $sql = "INSERT INTO `questions` (`question_id`, `question_type`, `question_content`, `question_credits`, `answer_content`, `answer_a`, `answer_b`, `answer_c`, `answer_d`, `user_id`) 
    VALUES (NULL, '$question_type', '$question_content', '$question_credits', '$answer_content', '$answer_a', '$answer_b', '$answer_c', '$answer_d', '$user_id');";



    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";

        //using get last to get back question_id of the question that was just inserted

        $question_id = mysqli_insert_id($conn);

        $sql = "INSERT INTO `quiz_questions` (`quiz_question_id`, `quiz_id`, `question_id`) 
        VALUES (NULL, '$quiz_id', '$question_id');";

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
<div onload="show1();">
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

        Question type <br>
        <input type="radio" name="question_type" id="multiple_choice" onclick="show1();" value="Multiple Choice">
        <label for="multiple_choice">Multiple Choice</label><br>

        <input type="radio" name="question_type" id="true_or_false" onclick="show2();" value="True or False">
        <label for="true_or_false"> True or False </label><br>

        <input type="radio" name="question_type" id="fill_in_the_blank" onclick="show3();" value="Fill in the blank">
        <label for="fill_in_the_blank">Fill in the blank</label><br>


        Question<br>
        <input type="text" name="question_content" placeholder="Enter Question Content"> <br>
        <br>

        Question Credit Value<br>
        <input type="number" min="1" max="3" name="question_credits" placeholder="Enter Question Credit Value"> <br>
        <br>

        <div id="answer_true_or_false">
            <label for="answer_true_or_false">Select Corrent Answer: True or False</label><br>
            <select name="answer_content">
                <option value="True">True</option>
                <option value="False">False</option>
            </select>
        </div>

        <div id="answer_content">
            <label for="answer_content">Answer</label>
            <br>
            <input type="text" name="answer_content" placeholder="Enter Answer Content"> <br>
            <br>
        </div>






        <br>
        <br>



        <div id="answer_a">
            <label for="answer_a">Answer: A</label>
            <input type="text" name="answer_a" id="answer_field_a" placeholder="Enter Answer A"> <br>
            <br>
        </div>


        <div id="answer_b"><br>
            <label for="answer_b">Answer: B</label>
            <input type="text" name="answer_b" id="answer_field_b" placeholder="Enter Answer B"> <br>
            <br>
        </div>


        <div id="answer_c"><br>
            <label for="answer_c">Answer: C</label>
            <input type="text" name="answer_c" id="answer_field_c" placeholder="Enter Answer C"> <br>
            <br>
        </div>


        <div id="answer_d"><br>
            <label for="answer_d">Answer: D</label>
            <input type="text" name="answer_d" id="answer_field_d" placeholder="Enter Answer D"> <br>
            <br>
        </div>


        <input type="submit" name="add_questions" value="Create Question">




    </form>
</div>
<script>
    function show0() {
        document.getElementById('answer_true_or_false').style.display = 'none';
        document.getElementById('answer_content').style.display = 'none';
        document.getElementById('answer_a').style.display = 'none';
        document.getElementById('answer_b').style.display = 'none';
        document.getElementById('answer_c').style.display = 'none';
        document.getElementById('answer_d').style.display = 'none';
        document.getElementById('answer_field_a').value = "";
        document.getElementById('answer_field_b').value = "";
        document.getElementById('answer_field_c').value = "";
        document.getElementById('answer_field_d').value = "";

    }


    function show1() {
        document.getElementById('answer_true_or_false').style.display = 'none';
        document.getElementById('answer_content').style.display = 'block';
        document.getElementById('answer_a').style.display = 'block';
        document.getElementById('answer_b').style.display = 'block';
        document.getElementById('answer_c').style.display = 'block';
        document.getElementById('answer_d').style.display = 'block';
        document.getElementById('answer_field_a').value = "";
        document.getElementById('answer_field_b').value = "";
        document.getElementById('answer_field_c').value = "";
        document.getElementById('answer_field_d').value = "";
    }

    function show2() {

        document.getElementById('answer_true_or_false').style.display = 'block';
        document.getElementById('answer_content').style.display = 'none';
        document.getElementById('answer_a').style.display = 'block';
        document.getElementById('answer_b').style.display = 'block';
        document.getElementById('answer_c').style.display = 'none';
        document.getElementById('answer_d').style.display = 'none';
        document.getElementById('answer_field_a').value = "True";
        document.getElementById('answer_field_b').value = "False";
        document.getElementById('answer_field_c').value = "";
        document.getElementById('answer_field_d').value = "";
    }


    function show3() {
        document.getElementById('answer_true_or_false').style.display = 'none';
        document.getElementById('answer_content').style.display = 'block';
        document.getElementById('answer_a').style.display = 'none';
        document.getElementById('answer_b').style.display = 'none';
        document.getElementById('answer_c').style.display = 'none';
        document.getElementById('answer_d').style.display = 'none';
        document.getElementById('answer_field_a').value = "";
        document.getElementById('answer_field_b').value = "";
        document.getElementById('answer_field_c').value = "";
        document.getElementById('answer_field_d').value = "";
    }
</script>