<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
}
$error = "9";
$page_title = "Create Quizzes";

// Code for page goes here

if (isset($_POST["add_quiz"])) {

    require "db_connect.php";


    $unit_id = mysqli_real_escape_string($conn, trim($_POST["unit_id"]));
    $quiz_name = mysqli_real_escape_string($conn, trim($_POST["quiz_name"]));
    $quiz_desc = mysqli_real_escape_string($conn, trim($_POST["quiz_desc"]));
    $quiz_tip = mysqli_real_escape_string($conn, trim($_POST["quiz_tip"]));
    $quiz_tip_timer = mysqli_real_escape_string($conn, trim($_POST["quiz_tip_timer"]));
    $user_id = $_SESSION["user_id"];



    $sql = "INSERT INTO `quizzes` (`quiz_id`, `quiz_name`, `quiz_desc`, `quiz_tip`, `quiz_tip_timer`, `unit_id`, `user_id`) 
    VALUES (NULL, '$quiz_name', '$quiz_desc', '$quiz_tip', '$quiz_tip_timer', '$unit_id', '$user_id');";

    if (mysqli_query($conn, $sql)) {
        $error = "0";
    } else {
        $error = "1";
    }
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
                Quiz creation Failed
            </div>
            <?php

            }
            ?>

            <?php if ($error == 0) {
                ?>
            <div class="alert alert-success" role="alert">
                Quiz Creation Successful!
            </div>
            <?php

            }
            ?>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-lg-6 mx-auto">
            <div class="registration mx-auto d-block w-100">
                <div class="page-header text-center">
                    <h1>Add Quiz</h1>
                </div>

                <form action="add_quizzes.php" method="post" class="form-validate form-horizontal well">
                    <fieldset>
                        <legend>Add your quiz here!</legend>

                        <div class="form-group">
                            <label for="">Select Unit:</label>
                            <select class="form-control" name="unit_id" id="">
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

                            </select></div>
                        <div class="form-group">
                            <label for="quiz_name">Quiz Name</label>
                            <input type="text" class="form-control" placeholder="Enter Quiz Name" name="quiz_name" id="quiz_name" required>
                        </div>

                        <div id="quiz_desc" class="form-group">
                            <label for="unit_desc">Quiz Description</label>
                            <textarea name="quiz_desc" id="quiz_desc" class="form-control" cols="30" rows="10" required></textarea> <br>
                        </div>
                        <div class="form-group">
                            <label for="quiz_tip">Quiz Tip</label>
                            <input type="text" class="form-control" placeholder="Enter Quiz Tip" name="quiz_tip" id="quiz_tip" required>
                        </div>
                        <div class="form-group">
                            <label for="quiz_tip_timer">Quiz Tip Timer</label>
                            <input type="number" min="15" max="60" name="quiz_tip_timer" placeholder="Enter Quiz Tip Timer" id="quiz_tip_timer" class="form-control" required> <br>
                        </div>

                        <div class="form-group d-flex justify-content-start">
                            <input type="submit" class="btn btn-primary" name="add_quiz" value="Create Quiz">
                        </div>

            </div>
            <br>
            <br>
            <br>
            <div>Now Add some questions to your quiz <a class="btn btn-primary" href="add_questions_to_quizzes.php">Add Questions</a> </div>
            </fieldset>
            </form>
        </div>
    </div>
</div>
</div>

<?php include "footer.php"; ?>