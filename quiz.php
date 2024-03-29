<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
}



// Code for page goes here

require "db_connect.php";

//Make sure you came from instructions page by checking for session variables

if (isset($_SESSION["attempt_id"])) {


    $attempt_id = $_SESSION["attempt_id"];
    $attempt_score = $_SESSION["attempt_score"];
    $quiz_id = $_SESSION["quiz_id"];
    $quiz_name = $_SESSION["quiz_name"];
    $quiz_tip = $_SESSION["quiz_tip"];
    $quiz_tip_timer = $_SESSION["quiz_tip_timer"];
    $quiz_question_num = $_SESSION["quiz_question_num"];
    $quiz_question_total = $_SESSION["quiz_question_total"];
} else {
    header("location: courses.php");
}

$page_title = "$quiz_name";

//default values for page before interaction
$feedback_icon = "fas fa-edit fa-2x";
$feedback_message = "";
//empty string so that response does not display until it is set
$response = "";
$button = "submit";


if (isset($_POST["submit"])) {

    $response = $_POST["response"];
    $answer_content = $_SESSION["answer_content"];
    $correct = 0;
    $button = "continue";
    $quiz_question_id = $_SESSION["quiz_question_id"];

    //checking if submitted response is correct or not
    if (strcasecmp($response, $answer_content) == 0) {
        $correct = 1;
        $feedback_icon = "fas fa-check-square text-success fa-2x";
        $feedback_message = "Correct!";
        $user_id = $_SESSION["user_id"];
        $sql = "SELECT * FROM quiz_responses, attempts 
        WHERE quiz_question_id = $quiz_question_id 
        AND response_score = 1 
        AND attempts.attempt_id = quiz_responses.attempt_id 
        AND attempts.user_id = $user_id";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $_SESSION["question_credits"] = 0;
        }

        //check response table to see if question was done before
        $_SESSION["attempt_credits"] += $_SESSION["question_credits"];
    } else {
        $correct = 0;
        $feedback_icon = "fas fa-times text-danger fa-2x";
        $feedback_message = "Incorrect.";
    }


    //counting score between questions
    $_SESSION["attempt_score"] += $correct;


    $sql = "INSERT INTO `quiz_responses` (`response_id`, `response_score`, `quiz_question_id`, `attempt_id`)
     VALUES (NULL, '$correct', '$quiz_question_id', '$attempt_id');";

    if (mysqli_query($conn, $sql)) { } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
//moves to the next question 

if (isset($_POST["continue"])) {
    $quiz_question_num += 1;
    $_SESSION["quiz_question_num"] = $quiz_question_num;
    $button = "submit";
}
if ($quiz_question_num > $quiz_question_total) {
    // because questions are completed


    $quiz_question_num = 1;
    $_SESSION["quiz_question_num"] = 1;
    header("location:results.php");
}

//pull question from database
$sql = "SELECT *
FROM quiz_questions, quizzes, questions
WHERE quiz_questions.quiz_id = quizzes.quiz_id
AND quiz_questions.question_id = questions.question_id
AND quiz_questions.quiz_id = $quiz_id
LIMIT $quiz_question_num";


$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {


        $answer_a = $row["answer_a"];
        $answer_b = $row["answer_b"];
        $answer_c = $row["answer_c"];
        $answer_d = $row["answer_d"];
        $question_content = $row["question_content"];
        $question_type = $row["question_type"];
        $_SESSION["answer_content"] = $row["answer_content"];
        $_SESSION["quiz_question_id"] = $row["quiz_question_id"];
        $_SESSION["question_credits"] = $row["question_credits"];
    }
} else {
    echo "0 results";
}


include "header.php";
?>
<!-- page specific styling goes here -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

<!-- <?php include "navbar.php"; ?> -->

<!-- content for the page starts here -->

<!-- display format for fill in the blank -->
<?php
if (strcasecmp($question_type, "Fill in the Blank") == 0) {

    ?>
<div class="container">
    <h1>Quiz</h1>
    <div class="card">
        <h5 class="card-title card-header"><?php echo $question_content; ?></h5>



        <form action="quiz.php" method="post">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="form-group">
                        <label for="">Type your answer:</label>
                        <input type="text" name="response" value="<?php echo $response; ?>">
                    </div>

                </li>
                <li class="list-group-item">
                    <div><?php echo $feedback_message; ?>
                        <span class="<?php echo $feedback_icon; ?>"></span>
                    </div>
                </li>
            </ul>

            <div class="card-body">
                <input type="submit" name="<?php echo $button; ?>" class=" btn btn-primary" value="<?php if ($button == "submit") {
                                                                                                            echo "Submit";
                                                                                                        } elseif ($button == "continue") {
                                                                                                            echo "Continue";
                                                                                                        } ?>">
                Question <?php echo $quiz_question_num; ?> out of <?php echo $quiz_question_total; ?>
        </form>
    </div>
</div>
</div>


<?php
}


//display format for multiple choice 

elseif (strcasecmp($question_type, "Multiple Choice") == 0) {

    $answers = array($answer_a, $answer_b, $answer_c, $answer_d);
    shuffle($answers);

    ?>

<div class="container">
    <h1>Quiz</h1>
    <div class="card">
        <h5 class="card-title card-header"><?php echo $question_content; ?></h5>



        <form action="quiz.php" method="post">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="custom-control custom-radio">
                        <input type="radio" name="response" id="answer_a" class="custom-control-input" value="<?php echo $answers[0]; ?>">
                        <label class="custom-control-label" for="answer_a"><?php echo $answers[0]; ?></label><br>
                    </div>

                <li class="list-group-item">
                    <div class="custom-control custom-radio">
                        <input type="radio" name="response" id="answer_b" class="custom-control-input" value="<?php echo $answers[1]; ?>">
                        <label class="custom-control-label" for="answer_b"><?php echo $answers[1]; ?></label><br>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="custom-control custom-radio">
                        <input type="radio" name="response" id="answer_c" class="custom-control-input" value="<?php echo $answers[2]; ?>">
                        <label class="custom-control-label" for="answer_c"><?php echo $answers[2]; ?></label><br>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="custom-control custom-radio">
                        <input type="radio" name="response" id="answer_d" class="custom-control-input" value="<?php echo $answers[3]; ?>">
                        <label class="custom-control-label" for="answer_d"><?php echo $answers[3]; ?></label><br>
                    </div>
                </li>
                <li class="list-group-item">
                    <div><?php echo $feedback_message; ?>
                        <span class="<?php echo $feedback_icon; ?>"></span>
                    </div>
                </li>
            </ul>

            <div class="card-body">
                <input type="submit" name="<?php echo $button; ?>" class=" btn btn-primary" value="<?php if ($button == "submit") {
                                                                                                            echo "Submit";
                                                                                                        } elseif ($button == "continue") {
                                                                                                            echo "Continue";
                                                                                                        } ?>">
                Question <?php echo $quiz_question_num; ?> out of <?php echo $quiz_question_total; ?>
        </form>
    </div>
</div>
</div>


<?php
} elseif (strcasecmp($question_type, "True or False") == 0) {

    ?>

<div class="container">
    <h1>Quiz</h1>
    <div class="card">
        <h5 class="card-title card-header"><?php echo $question_content; ?></h5>



        <form action="quiz.php" method="post">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="custom-control custom-radio">
                        <input type="radio" name="response" id="answer_a" class="custom-control-input" value="<?php echo $answer_a; ?>">
                        <label class="custom-control-label" for="answer_a"><?php echo $answer_a; ?></label><br>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="custom-control custom-radio">
                        <input type="radio" name="response" id="answer_b" class="custom-control-input" value="<?php echo $answer_b; ?>">
                        <label class="custom-control-label" for="answer_b"><?php echo $answer_b; ?></label><br>
                    </div>
                </li>
                <li class="list-group-item">
                    <div><?php echo $feedback_message; ?>
                        <span class="<?php echo $feedback_icon; ?>"></span>
                    </div>
                </li>
            </ul>

            <div class="card-body">
                <input type="submit" name="<?php echo $button; ?>" class=" btn btn-primary" value="<?php if ($button == "submit") {
                                                                                                            echo "Submit";
                                                                                                        } elseif ($button == "continue") {
                                                                                                            echo "Continue";
                                                                                                        } ?>">
                Question <?php echo $quiz_question_num; ?> out of <?php echo $quiz_question_total; ?>
        </form>
    </div>
</div>
</div>


<?php
} else {
    echo "no question type recognised";
}
?>



<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Hint</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <?php echo "$quiz_tip"; ?>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close Hint</button>
            </div>

        </div>
    </div>
</div>



<?php include "footer.php"; ?>


<script type="text/javascript">
    setTimeout(function() {
        $("#myModal").modal();
    }, <?php echo $quiz_tip_timer; ?>000);
</script>