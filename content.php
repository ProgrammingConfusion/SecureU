<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
}

if (isset($_GET["course_id"]) && isset($_GET["unit_id"])) {
    $course_id = $_GET["course_id"];
    $unit_id = $_GET["unit_id"];
    $forum_link = "forum.php?course_id=$course_id&unit_id=$unit_id";
} else {
    header("location: courses.php");
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

<style>
    @import url(//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css);

    .card .card-image {
        overflow: hidden;
        -webkit-transform-style: preserve-3d;
        -moz-transform-style: preserve-3d;
        -ms-transform-style: preserve-3d;
        -o-transform-style: preserve-3d;
        transform-style: preserve-3d;
    }


    .card {
        margin-top: 10px;
        position: relative;
        -webkit-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
        -moz-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
        box-shadow: 4 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    }

    .card .card-content {
        padding: 10px;
    }

    .card .card-content .card-title,
    .card-reveal .card-title {
        font-size: 24px;
        font-weight: 200;
    }

    .card .card-action {
        padding: 20px;
        border-top: 1px solid rgba(160, 160, 160, 0.2);
    }

    .card .card-action a {
        font-size: 15px;
        color: #ffab40;
        text-transform: uppercase;
        margin-right: 20px;
        -webkit-transition: color 0.3s ease;
        -moz-transition: color 0.3s ease;
        -o-transition: color 0.3s ease;
        -ms-transition: color 0.3s ease;
        transition: color 0.3s ease;
    }

    .card .card-action a:hover {
        color: #ffd8a6;
        text-decoration: none;
    }

    .card .card-reveal {
        padding: 20px;
        position: absolute;
        background-color: #FFF;
        width: 100%;
        overflow-y: auto;
        /*top: 0;*/
        left: 0;
        bottom: 0;
        height: 100%;
        z-index: 1;
        display: none;
    }

    .card .card-reveal p {
        color: rgba(0, 0, 0, 0.71);
        margin: 20px;
    }

    .btn-custom {
        background-color: transparent;
        font-size: 18px;
    }
</style>

<?php include "navbar.php"; ?>

<!-- content for the page starts here -->


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
<div class="container">
    <div class="row">
        <div class="col-md-6 ">
            <div class="card">
                <div class="card-image">
                    <div class="embed-responsive embed-responsive-16by9">
                        <?php echo $content_code; ?>
                    </div>

                </div><!-- card image -->

                <div class="card-content">
                    <span class="card-title font-weight-bold"><?php echo $content_name; ?></span>

                </div><!-- card content -->


            </div>
            <br>
            <br>
            <br>

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
            <div class="container">
                <div class="row">
                    <div class="col ">
                        <div class="card">
                            <div class="card-image">
                                <div><embed src="<?php echo $content_file; ?>" type="application/pdf" width="560px" height="560px" /></div>

                            </div><!-- card image -->

                            <div class="card-content">
                                <span class="card-title font-weight-bold"><?php echo $content_name; ?></span>

                            </div><!-- card content -->


                        </div>
                    </div>
                </div>
            </div>

            <br>
            <br>
            <br>



            <?php
                        }
                        ?>







            <?php
                    }
                }
            } else {
                echo "There is no Learning Content or Quiz for this unit yet";
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
                <div class="card border-primary">
                    <h3 class="card-title card-header"><?php echo $quiz_name; ?></h3>
                    <div class="card-body ">
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

            </div> <br><br>
            <div class="container">


                <div class="font-weight-bold"> Visit the Q&A forum if you have a question!
                    <a class=" btn btn-primary" href="<?php echo $forum_link; ?>">Visit Forum</a>
                </div>

            </div>