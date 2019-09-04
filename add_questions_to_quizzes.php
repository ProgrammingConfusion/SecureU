<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
}

$page_title = "Add Questions";

// Code for page goes here
$error = "9";

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


        //using get last to get back question_id of the question that was just inserted

        $question_id = mysqli_insert_id($conn);

        $sql = "INSERT INTO `quiz_questions` (`quiz_question_id`, `quiz_id`, `question_id`) 
        VALUES (NULL, '$quiz_id', '$question_id');";

        if (mysqli_query($conn, $sql)) {


            $sql = "UPDATE `quizzes` SET `quiz_question_total` = 
            (SELECT COUNT(*) FROM quiz_questions WHERE quiz_questions.quiz_id = $quiz_id) WHERE `quizzes`.`quiz_id` = $quiz_id;";

            if (mysqli_query($conn, $sql)) {
                $error = "0";
            } else {
                $error = "1";
            }
        } else { }
    } else { }
}

include "header.php";
?>
<!-- page specific styling goes here -->

<?php include "navbar.php"; ?>

<!-- content for the page starts here -->
<div class="container">
    <div class="row">
        <div class="col-md-6 col-lg-6 mx-auto">
            <?php if ($error == 1) {
                ?>
            <div class="alert alert-danger" role="alert">
                Question Creation Failed
            </div>
            <?php

            }
            ?>

            <?php if ($error == 0) {
                ?>
            <div class="alert alert-success" role="alert">
                Question Successfully Added!
            </div>
            <?php

            }
            ?>
        </div>
    </div>
</div>

<div onload="show1();">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-6 mx-auto">
                <div class="registration mx-auto d-block w-100">
                    <div class="page-header text-center">
                        <h1>Add Questions</h1>
                    </div>

                    <form action="add_questions_to_quizzes.php" method="post" class="form-validate form-horizontal well">
                        <fieldset>
                            <legend>Add your questions here!</legend>

                            <div class="form-group">
                                <label for="">Select Quiz:</label>
                                <select class="form-control" name="quiz_id" id="">
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
                                </select></div>

                            <label for="">Select Content Type*</label>
                            <div class="custom-control custom-radio">
                                <input type="radio" name="question_type" id="multiple_choice" class="custom-control-input" onclick="show1();" value="Multiple Choice">
                                <label for="multiple_choice" class="custom-control-label">Multiple Choice</label><br>
                            </div>
                            <br>
                            <div class="custom-control custom-radio">
                                <input type="radio" name="question_type" id="true_or_false" class="custom-control-input" onclick="show2();" value="True or False">
                                <label for="true_or_false" class="custom-control-label">True or False </label><br>
                            </div>
                            <br>
                            <div class="custom-control custom-radio">
                                <input type="radio" name="question_type" id="fill_in_the_blank" class="custom-control-input" onclick="show3();" value="Fill in the blank">
                                <label for="fill_in_the_blank" class="custom-control-label">Fill in the blank</label><br>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="question_content">Question Content</label>
                                <input type="text" class="form-control" placeholder="Enter Question Content" name="question_content" id="question_content">
                            </div>

                            <div class="form-group">
                                <label for="question_credits">Question Credit Value</label>
                                <input type="number" min="1" max="3" name="question_credits" placeholder="Enter Question Credit Value" id="question_credits" class="form-control">
                            </div>

                            <div id="answer_true_or_false" class="form-group">
                                <label for="answer_true_or_false">Select Correct Answer: True or False</label><br>
                                <input type="text" class="form-control" placeholder="Enter Answer Content" name="answer_content" id="answer_content">
                            </div>

                            <div class="form-group">
                                <label for="answer_content">Answer Content</label>
                                <input type="text" class="form-control" placeholder="Enter Answer Content" name="answer_content" id="answer_content">
                            </div>

                            <div class="form-group" id="answer_a">
                                <label for="answer_a">Answer: A</label>
                                <input type="text" class="form-control" name="answer_a" id="answer_field_a" placeholder="Enter Answer A">

                            </div>
                            <div class="form-group" id="answer_b">
                                <label for="answer_b">Answer: B</label>
                                <input type="text" class="form-control" name="answer_b" id="answer_field_b" placeholder="Enter Answer B">

                            </div>
                            <div class="form-group" id="answer_c">
                                <label for="answer_c">Answer: C</label>
                                <input type="text" class="form-control" name="answer_c" id="answer_field_c" placeholder="Enter Answer C">

                            </div>
                            <div class="form-group" id="answer_d">
                                <label for="answer_d">Answer: D</label>
                                <input type="text" class="form-control" name="answer_d" id="answer_field_d" placeholder="Enter Answer D">

                            </div>








                            <div class="form-group d-flex justify-content-start">
                                <input type="submit" class="btn btn-primary" name="add_questions" value="Add question">
                            </div>

                </div>
                <br>
                <br>
                <br>
                <div>Ensure you add enough questions to your quiz, then try out your course! <a class="btn btn-primary" href="courses.php">Go to Courses</a> </div>
                </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>



<br>
<br>









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