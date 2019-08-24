<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
}

$page_title = "Profile";

require "db_connect.php";
$user_id = $_SESSION["user_id"];
// Code for page goes here

$error = "9";
$img_error = 7;
if (isset($_POST["update_img"])) {

    $target_dir = "images/";
    $profile_img = $target_dir . basename($_FILES["profile_img"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($profile_img, PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if (isset($_POST["create_course"])) {
        $check = getimagesize($_FILES["profile_img"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
            $img_error = 1;
        }
    }
    // Check if file already exists
    if (file_exists($profile_img)) {
        $uploadOk = 0;
        $img_error = 2;
    }
    // Check file size
    if ($_FILES["profile_img"]["size"] > 5000000) {
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
        if (move_uploaded_file($_FILES["profile_img"]["tmp_name"], $profile_img)) {
            $img_error = 0;
        } else {
            $img_error = 5;
        }
    }
    if ($img_error == 0) {


        $sql = "UPDATE `users` SET `user_img` = '$profile_img' WHERE `users`.`user_id` = $user_id;";

        if (mysqli_query($conn, $sql)) {
            $error = 1;
        } else {
            $error = 2;
        }
    }
}

if (isset($_POST["update_profile"])) {






    $email = mysqli_real_escape_string($conn, trim($_POST["email"]));
    $username = mysqli_real_escape_string($conn, trim($_POST["username"]));
    $first_name = mysqli_real_escape_string($conn, trim($_POST["first_name"]));
    $last_name = mysqli_real_escape_string($conn, trim($_POST["last_name"]));
    $user_role = mysqli_real_escape_string($conn, trim($_POST["user_role"]));


    $sql = "UPDATE `users` SET `email` = '$email', `username` = '$username', `first_name` = '$first_name', `last_name` = '$last_name', `user_role` = '$user_role' WHERE `users`.`user_id` = $user_id;";

    if (mysqli_query($conn, $sql)) {
        $error = 0;
    } else {
        $error = 2;
    }
}

include "header.php";
?>
<!-- page specific styling goes here -->

<?php include "navbar.php"; ?>

<!-- content for the page starts here -->


<div class="container" style="padding-top: 60px;">
    <h1 class="page-header">Edit Profile</h1>
    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="text-center">



                <?php

                require "db_connect.php";

                $user_id = $_SESSION["user_id"];



                $sql = "SELECT * FROM users WHERE user_id=$user_id";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {

                        $first_name = $row["first_name"];
                        $last_name = $row["last_name"];
                        $username = $row["username"];
                        $email = $row["email"];
                        $user_role = $row["user_role"];
                        $user_img = $row["user_img"];
                        $user_credits = $row["user_credits"];
                    }

                    ?>
                <!-- left column -->

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
                <img src="<?php echo $user_img; ?>" class="avatar rounded-circle img-thumbnail" alt="avatar">
                <h6>Upload a different photo...</h6>


                <Form enctype="multipart/form-data" action="profile.php" method="post">
                    <input type="file" name="profile_img" id="profile_img" class="text-center center-block well well-sm">
                    <br>
                    <br>
                    <input type="submit" class="btn btn-primary" name="update_img" value="Update Image">
                </Form>
            </div>
            <br>
            <br>
            <ul class="list-group">
                <li class="list-group-item text-muted">Statistics <i class="fa fa-dashboard fa-1x"></i></li>
                <li class="list-group-item text-right"><span class="float-left"><strong>Credits</strong></span> <?php echo $user_credits; ?></li>
            </ul>
        </div>
        <!-- edit form column -->
        <div class="col-md-8 col-sm-6 col-xs-12 personal-info">
            <?php if ($error == 0) {

                    ?>
            <div class="alert alert-success alert-dismissable">
                <a class="panel-close close" data-dismiss="alert">×</a>
                <i class="fa fa-coffee"></i>
                Profile Updated Successfully
            </div>
            <?php } ?>
            <?php if ($error == 2) {

                    ?>
            <div class="alert alert-success alert-dismissable">
                <a class="panel-close close" data-dismiss="alert">×</a>
                <i class="fa fa-coffee"></i>
                Profile Update Failed
            </div>
            <?php } ?>
            <h3>Personal info</h3>
            <form class="form-horizontal" action="profile.php" method="post" role="form">
                <div class="form-group">
                    <label class="col-lg-3 control-label">First name:</label>
                    <div class="col-lg-8">
                        <input class="form-control" name="first_name" value="<?php echo $first_name; ?>" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Last name:</label>
                    <div class="col-lg-8">
                        <input class="form-control" name="last_name" value="<?php echo $last_name; ?>" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Email:</label>
                    <div class="col-lg-8">
                        <input class="form-control" name="email" value="<?php echo $email; ?>" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Username:</label>
                    <div class="col-md-8">
                        <input class="form-control" name="username" value="<?php echo $username; ?>" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">User Role</label>
                    <div class="col-lg-8">
                        <div class="ui-select">
                            <select id="user_time_zone" name="user_role" class="form-control" required>
                                <option value="" selected disabled hidden><?php echo $user_role; ?></option>
                                <option value="Tutor">Tutor</option>
                                <option value="Student">Student</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-8">
                        <input class="btn btn-primary" name="update_profile" value="Save Changes" type="submit">
                        <span></span>
                        <input class="btn btn-danger" value="Cancel" type="reset">
                    </div>
                </div>
            </form>
        </div>



        <?php

        } else {
            header("location: login.php");
        }
        ?>

    </div>
</div>

<?php include "footer.php"; ?>

<!-- page specific scripts go here -->