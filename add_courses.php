<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
}

$page_title = "Add Course";

$img_error = 7;
$error = 7;

if (isset($_POST["create_course"])) {


    require "db_connect.php";

    $course_name = mysqli_real_escape_string($conn, trim($_POST["course_name"]));
    $course_desc = mysqli_real_escape_string($conn, trim($_POST["course_desc"]));
    $user_id = $_SESSION["user_id"];
    // print_r($_POST);
    // print_r($_FILES);

    if (($_FILES["course_img"]["name"])) {



        $target_dir = "images/";
        $course_img = $target_dir . basename($_FILES["course_img"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($course_img, PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        if (isset($_POST["create_course"])) {
            $check = getimagesize($_FILES["course_img"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
                $img_error = 1;
            }
        }
        // Check if file already exists
        if (file_exists($course_img)) {
            $uploadOk = 0;
            $img_error = 2;
        }
        // Check file size
        if ($_FILES["course_img"]["size"] > 5000000) {
            $uploadOk = 0;
            $img_error = 3;
        }
        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            $uploadOk = 0;
            $img_error = 4;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {

            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["course_img"]["tmp_name"], $course_img)) {
                $img_error = 0;
            } else {
                $img_error = 5;
            }
        }
        if ($img_error == 0) {


            $sql = "INSERT INTO `courses` (`course_id`, `course_name`, `course_desc`, `course_img`, `course_status`, `date_created`, `user_id`)
     VALUES (NULL, '$course_name', '$course_desc', '$course_img', '', CURRENT_TIMESTAMP, '$user_id')";

            if (mysqli_query($conn, $sql)) {
                $error = 0;
            } else {
                $error = 1;
            }
        }
    } else {

        $sql = "INSERT INTO `courses` (`course_id`, `course_name`, `course_desc`, `course_img`, `course_status`, `date_created`, `user_id`)
        VALUES (NULL, '$course_name', '$course_desc', 'images/secure-your-computer-large-1024x669.jpg', '', CURRENT_TIMESTAMP, '$user_id')";

        if (mysqli_query($conn, $sql)) {
            $error = 0;
        } else {
            $error = 1;
        }
    }
}



include "header.php"; ?>

<?php include "navbar.php"; ?>

<div class="container">
    <div class="row">
        <div class="col-md-6 col-lg-6 mx-auto">
            <?php if ($img_error == 0) {
                ?>
            <div class="alert alert-success" role="alert">
                Image Uploaded.
            </div>
            <?php

            }
            ?>
            <?php if ($img_error == 1) {
                ?>
            <div class="alert alert-danger" role="alert">
                File is not an image.
            </div>
            <?php

            }
            ?>
            <?php if ($img_error == 2) {
                ?>
            <div class="alert alert-danger" role="alert">
                Sorry, file already exists.
            </div>
            <?php

            }
            ?>
            <?php if ($img_error == 3) {
                ?>
            <div class="alert alert-danger" role="alert">
                Sorry, your file is too large.
            </div>
            <?php

            }
            ?>
            <?php if ($img_error == 4) {
                ?>
            <div class="alert alert-danger" role="alert">
                Sorry, only JPG, JPEG, PNG & GIF files are allowed.
            </div>
            <?php

            }
            ?>
            <?php if ($img_error == 5) {
                ?>
            <div class="alert alert-danger" role="alert">
                Sorry, there was an error uploading your file.
            </div>
            <?php

            }
            ?>

            <?php if ($error == 0) {
                ?>
            <div class="alert alert-success" role="alert">
                Course Successfully created.
            </div>
            <?php

            }
            ?>

            <?php if ($error == 1) {
                ?>
            <div class="alert alert-danger" role="alert">
                Course creation unsuccessful.
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
                    <h1>Create Course</h1>
                </div>

                <form action="add_courses.php" method="post" class="form-validate form-horizontal well" enctype="multipart/form-data">
                    <fieldset>
                        <legend>Create your course here!</legend>
                        <div class="form-group">
                            <label for="course_name">CourseName</label>
                            <input type="text" class="form-control" placeholder=" Enter Course Name" name="course_name" id="course_name" required>
                        </div>
                        <div id="content_code" class="form-group">
                            <label for="course_desc">Course Description</label>
                            <textarea name="course_desc" id="course_desc" class="form-control" cols="30" rows="10" required></textarea> <br>
                        </div>
                        <div id="course_img">
                            <label for="course_img">Course Image</label><br>
                            <input type="file" name="course_img" id="course_img" class="form-control-file border">
                        </div>



                        <div class="d-flex justify-content-between align-items-center">
                            <div class="form-group d-flex justify-content-start">
                                <input type="submit" class="btn btn-primary" name="create_course" value="Create Course">
                            </div>







                            <br>


                        </div>
                        <br>
                        <br>
                        <br>
                        <div>Now Create a unit for your course! <a class="btn btn-primary" href="add_units.php">Create Units</a> </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>


<a href="add_units.php">Create Units</a>










<?php include "footer.php"; ?>