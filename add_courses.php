<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
}

$page_title = "Add Course";



if (empty($_POST["course_img"]) && isset($_POST["create_course"])) {


    require "db_connect.php";

    $course_name = mysqli_real_escape_string($conn, trim($_POST["course_name"]));
    $course_desc = mysqli_real_escape_string($conn, trim($_POST["course_desc"]));
    $user_id = $_SESSION["user_id"];

    $sql = "INSERT INTO `courses` (`course_id`, `course_name`, `course_desc`, `course_img`, `course_status`, `date_created`, `user_id`)
        VALUES (NULL, '$course_name', '$course_desc', 'images/secure-your-computer-large-1024x669.jpg', '', CURRENT_TIMESTAMP, '$user_id')";

    if (mysqli_query($conn, $sql)) {
        echo "New course created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
} elseif (isset($_POST["create_course"]) && isset($_POST["course_img"])) {



    require "db_connect.php";

    $course_name = mysqli_real_escape_string($conn, trim($_POST["course_name"]));
    $course_desc = mysqli_real_escape_string($conn, trim($_POST["course_desc"]));
    $user_id = $_SESSION["user_id"];

    $target_dir = "images/";
    $course_img = $target_dir . basename($_FILES["course_img"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($course_img, PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if (isset($_POST["create_course"])) {
        $check = getimagesize($_FILES["course_img"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    // Check if file already exists
    if (file_exists($course_img)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["course_img"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["course_img"]["tmp_name"], $course_img)) {
            echo "The file " . basename($_FILES["course_img"]["name"]) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    $sql = "INSERT INTO `courses` (`course_id`, `course_name`, `course_desc`, `course_img`, `course_status`, `date_created`, `user_id`)
     VALUES (NULL, '$course_name', '$course_desc', '$course_img', '', CURRENT_TIMESTAMP, '$user_id')";

    if (mysqli_query($conn, $sql)) {
        echo "New course created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}




include "header.php"; ?>

<!-- <?php include "navbar.php"; ?> -->

<h2> Create Course</h2>

<form action="add_courses.php" method="post" enctype="multipart/form-data"> Course Name <br>
    <input type="text" name=course_name placeholder=" Enter Course Name"> <br>
    <br>

    Course Description <br>
    <textarea name="course_desc" placeholder="Enter Course Description" cols="30" rows="10"></textarea><br>
    <br>

    Course Image <br>
    <input type="file" name="course_img" id="course_img">
    <br>
    <br>


    <input type="submit" name="create_course" value="Create Course">


</form>

<a href="add_units.php">Create Units</a>










<?php include "footer.php"; ?>