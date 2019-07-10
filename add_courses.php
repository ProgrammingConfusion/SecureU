<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
}

$page_title = "Add Course";

if (isset($_POST["create_course"])) {

    require "db_connect.php";

    $course_name = mysqli_real_escape_string($conn, trim($_POST["course_name"]));
    $course_desc = mysqli_real_escape_string($conn, trim($_POST["course_desc"]));
    $user_id = $_SESSION["user_id"];

    $sql = "INSERT INTO `courses` (`course_id`, `course_name`, `course_desc`, `course_img`, `course_status`, `date_created`, `user_id`)
     VALUES (NULL, '$course_name', '$course_desc', '', '', CURRENT_TIMESTAMP, '$user_id')";

    if (mysqli_query($conn, $sql)) {
        echo "New course created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}




include "header.php"; ?>

<h2> Create Course</h2>

<form action="add_courses.php" method="post">

    Course Name <br>
    <input type="text" name=course_name placeholder="Enter Course Name"> <br>
    <br>

    Course Description <br>
    <textarea name="course_desc" placeholder="Enter Course Description" cols="30" rows="10"></textarea><br>
    <br>


    <input type="submit" name="create_course" value="Create Course">


</form>










<?php include "footer.php"; ?>