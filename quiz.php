<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
}

$page_title = "Quiz";

// Code for page goes here

require "db_connect.php";

//Make sure you came from instructions page by checking for session variables

if (isset($_SESSION["attempt_id"])) {


    $attempt_id = $_SESSION["attempt_id"];
    $attempt_score = $_SESSION["attempt_score"];
    $quiz_id = $_SESSION["quiz_id"];
    $quiz_question_num = $_SESSION["quiz_question_num"];
    $quiz_question_total = $_SESSION["quiz_question_total"];
}


//default values for page before interaction
$feedback_icon = "fas fa-edit fa-2x";
$feedback_message = "";
//empty string so that response does not display until it is set
$response = "";
$button = "Submit";


if (isset($_POST["submit"])) {

    $response = $_POST["response"];
    $answer_content = $_SESSION["answer_content"];
    $correct = 0;
    $button = "Submit";
    $quiz_question_id = $_SESSION["quiz_question_id"];

    //checking if submitted response is correct or not
    if (strcasecmp($response, $answer_content) == 0) {
        $correct = 1;
        $feedback_icon = "fas fa-check-square text-success fa-2x";
        $feedback_message = "Correct!";
    } else {
        $correct = 0;
        $feedback_icon = "fas fa-times text-danger fa-2x";
        $feedback_message = "Incorrect.";
    }


    //counting score between questions
    $_SESSION["attempt_score"] += $correct;

    $sql = "INSERT INTO `quiz_responses` (`response_id`, `response_content`, `response_score`, `quiz_question_id`, `attempt_id`)
     VALUES (NULL, '', '$correct', '$quiz_question_id', '$attempt_id');";

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    //moves to the next question 

}

if (isset($_POST["continue"])) {
    $quiz_question_num += 1;
    $_SESSION["quiz_question_num"] = $quiz_question_num;
}
if ($quiz_question_num > $quiz_question_total) {
    // because questions are completed


    $quiz_question_num = 1;
    $_SESSION["quiz_question_num"] = 1;
    header("location:results.php");
}


$sql = "SELECT *
FROM quiz_questions, quizzes, questions
WHERE quiz_questions.quiz_id = quizzes.quiz_id
AND quiz_questions.question_id = questions.question_id
AND quiz_questions.quiz_id = $quiz_id
AND quiz_questions.quiz_question_num = $quiz_question_num";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {



        $question_content = $row["question_content"];
        $_SESSION["answer_content"] = $row["answer_content"];
        $_SESSION["quiz_question_id"] = $row["quiz_question_id"];
    }
} else {
    echo "0 results";
}


include "header.php";
?>
<!-- page specific styling goes here -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

<?php include "navbar.php"; ?>

<!-- content for the page starts here -->

<h3>Question <?php echo $quiz_question_num; ?> out of <?php echo $quiz_question_total; ?></h3>
<h4> <?php echo $question_content; ?></h4>
<form action="quiz.php" method="post">
    <input type="text" name="response" value="<?php echo $response; ?>">
    <input type="submit" name="submit" value="<?php echo $button; ?>">
    <input type="submit" name="continue" value="Next Question">
</form>
<div><?php echo $feedback_message; ?> </div>
<span class="<?php echo $feedback_icon; ?>"></span>
<br>
<br>










<!-- way of progressing through quiz with only one button  -->
<!-- <h3>Question <?php echo $quiz_question_num; ?> out of <?php echo $quiz_question_total; ?></h3>
<h4> <?php echo $question_content; ?></h4>
<form action="quiz.php" method="post">
    <input type="text" name="response" value="<?php echo $response; ?>">
    <input type="submit" name="submit" value="<?php echo $button; ?>">
</form>
<div><?php echo $feedback_message; ?> </div>
<span class="<?php echo $feedback_icon; ?>"></span>
<br>
<br> -->


<!-- Old way of displaying feedback -->
<!-- <?php
        if ($correct == 1) {
            ?>

                                                                                                                                                                    <h2>Correct! <span class="fas fa-check-square text-success"></span></h2>
<?php
} else {
    ?>
                                                                                                                                                                    <h2>Incorrect <span class="fas fa-times text-danger"></span></h2>
<?php
}
?> -->