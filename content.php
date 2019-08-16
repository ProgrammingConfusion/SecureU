<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
}

if (isset($_GET["course_id"]) && isset($_GET["unit_id"])) {
    $course_id = $_GET["course_id"];
    $unit_id = $_GET["unit_id"];
    $forum_link = "forum.php?course_id=$course_id&unit_id=$unit_id";
}
require "db_connect.php";

$sql = "SELECT * FROM `content` WHERE unit_id = $unit_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        $content_name = $row["content_name"];
    }
    $page_title = "$content_name";
    $content = "content";
} else {
    $sql = "SELECT * FROM `quizzes` WHERE unit_id = $unit_id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            $quiz_name = $row["quiz_name"];
        }
        $page_title = "$quiz_name";
        $content = "quiz";
    }
}


// Code for page goes here



$result = mysqli_query($conn, $sql);



include "header.php";
?>
<!-- page specific styling goes here -->

<?php include "navbar.php"; ?>

<!-- content for the page starts here -->


<a class="btn btn-primary" href="<?php echo $forum_link; ?>">Forum</a>

<?php


if ($content = "content") {
    $sql = "SELECT * FROM `content` WHERE unit_id = $unit_id ORDER BY content_num ASC";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            $content_id = $row["content_id"];
            $content_name = $row["content_name"];
            $content_num = $row["content_num"];
            $content_type = $row["content_type"];
            $content_code = $row["content_code"];
            $content_file = $row["content_file"];

            if (strcasecmp($content_type, "Video") == 0) {

                ?>
<h1><?php echo $content_name; ?></h1>

<p><?php echo $content_code; ?> </p>
<?php
            }
            ?>
<?php
            if (strcasecmp($content_type, "Slide") == 0) {

                ?>
<h1><?php echo $content_name; ?></h1>

<p><?php echo $content_code; ?> </p>
<?php
            }
            ?>

<?php
            if (strcasecmp($content_type, "PDF") == 0) {

                ?>
<h1><?php echo $content_name; ?></h1>

<div><embed src="<?php echo $content_file; ?>" type="application/pdf" width="75%" height="600px" /></div>
<?php
            }
            ?>







<?php
        }
    }
} else {
    echo "0 results";
}
?>
<div class="container">
    <?php
    if ($content = "quiz") {
        $sql = "SELECT * FROM `quizzes` WHERE unit_id = $unit_id";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                $quiz_id = $row["quiz_id"];
                $quiz_name = $row["quiz_name"];
                $quiz_desc = $row["quiz_desc"];
                $quiz_link = "instructions.php?course_id=$course_id&unit_id=$unit_id&quiz_id=$quiz_id";

                ?>
    <div class="card">
        <div class="card-body ">
            <h3 class="card-title"><?php echo $quiz_name; ?></h3>
            <p class="card-text"> <?php echo $quiz_desc; ?></p>
            <a class="btn btn-primary" href="<?php echo $quiz_link; ?>">Select</a>

        </div>
    </div>



    <?php
            }
        }
    } else {
        echo "No quiz found.";
    }
    ?>
</div>