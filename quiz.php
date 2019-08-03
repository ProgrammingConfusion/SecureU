<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
}

$page_title = "Quiz";

// Code for page goes here

require "db_connect.php";

//hardcoding temp for testing
$quiz_id = 1;
$unit_id = 8;
$attempt_id = 1;
$quiz_question_num = 2;
$quiz_question_total = 3;

if (isset($_SESSION["quiz_question_num"])) {
    $quiz_question_num = $_SESSION["quiz_question_num"];
} else {
    $quiz_question_num = 1;
    $_SESSION["quiz_question_num"] = $quiz_question_num;
}


if (isset($_POST["submit"])) {

    $response = $_POST["response"];
    $answer_content = $_SESSION["answer_content"];

    if (strcasecmp($response, $answer_content) == 0) {
        $correct = 1;
    } else {
        $correct = 0;
    }

    $quiz_question_num += 1;
    $_SESSION["quiz_question_num"] = $quiz_question_num;
}

if ($quiz_question_num > $quiz_question_total) {
    // because questions are completed
    echo "Finished!";

    $quiz_question_num = 1;
    $_SESSION["quiz_question_num"] = 1;
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
    }
} else {
    echo "0 results";
}


include "header.php";
?>
<!-- page specific styling goes here -->

<?php include "navbar.php"; ?>

<!-- content for the page starts here -->

<h3>Question <?php echo $quiz_question_num; ?> out of <?php echo $quiz_question_total; ?></h3>
<h4> <?php echo $question_content; ?></h4>
<form action="quiz.php" method="post">
    <input type="text" name="response">
    <input type="submit" name="submit">
</form>

<?php
if ($correct == 1) {
    ?>

    <h2>Correct!</h2>
<?php
} else {
    ?>
    <h2>Incorrect</h2>
<?php
}
?>