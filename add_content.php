<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
}

$page_title = "Add Content";


$file_error = 7;
$error = 7;

if (isset($_POST["add_content"])) {
    require "db_connect.php";

    $unit_id = mysqli_real_escape_string($conn, trim($_POST["unit_id"]));
    $content_name = mysqli_real_escape_string($conn, trim($_POST["content_name"]));
    $content_num = mysqli_real_escape_string($conn, trim($_POST["content_num"]));
    $content_type = mysqli_real_escape_string($conn, trim($_POST["content_type"]));
    $content_code = mysqli_real_escape_string($conn, trim($_POST["content_code"]));


    if (($_FILES["content_file"]["name"])) {




        $target_dir = "content_files/";
        $content_file = $target_dir . basename($_FILES["content_file"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($content_file, PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        if (isset($_POST["create_course"])) {
            $check = getimagesize($_FILES["content_file"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
                $file_error = 1;
            }
        }
        // Check if file already exists
        if (file_exists($content_file)) {
            $uploadOk = 0;
            $file_error = 2;
        }
        // Check file size
        if ($_FILES["content_file"]["size"] > 5000000) {
            $uploadOk = 0;
            $file_error = 3;
        }
        // Allow certain file formats
        if (
            $imageFileType != "pdf"
        ) {
            $uploadOk = 0;
            $file_error = 4;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {

            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["content_file"]["tmp_name"], $content_file)) {
                $file_error = 0;
            } else {
                $file_error = 5;
            }
        }
        if ($file_error == 0) {

            $sql = "INSERT INTO `content` (`content_id`, `content_name`, `content_num`, `content_type`, `content_code`, `content_file`, `unit_id`)
            VALUES (NULL, '$content_name', '$content_num', '$content_type', '$content_code', '$content_file', '$unit_id');";




            if (mysqli_query($conn, $sql)) {
                $error = 0;
            } else {
                $error = 1;
            }
        }
    } else {

        $sql = "INSERT INTO `content` (`content_id`, `content_name`, `content_num`, `content_type`, `content_code`, `content_file`, `unit_id`)
            VALUES (NULL, '$content_name', '$content_num', '$content_type', '$content_code', '', '$unit_id');";



        if (mysqli_query($conn, $sql)) {
            $error = 0;
        } else {
            $error = 1;
        }
    }
}




include "header.php";
?>

<?php // include "navbar.php"; 
?>
<!-- $unit_id = mysqli_real_escape_string($conn, trim($_POST["unit_id"]));
$content_name = mysqli_real_escape_string($conn, trim($_POST["content_name"]));
$content_num = mysqli_real_escape_string($conn, trim($_POST["content_num"]));
$content_type = mysqli_real_escape_string($conn, trim($_POST["content_type"]));
$content_code = mysqli_real_escape_string($conn, trim($_POST["content_code"])); -->

<form action="add_content.php" method="post" enctype="multipart/form-data">


    <h2> Add Content</h2>



    Select Unit <br>
    <select name="unit_id" placeholder="Select Unit">
        <?php

        require "db_connect.php";

        $user_id = $_SESSION["user_id"];

        $sql = "SELECT * FROM units, courses WHERE units.course_id = courses.course_id AND units.user_id = $user_id ORDER BY unit_name ASC";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while ($row = mysqli_fetch_assoc($result)) {

                $unit_id = $row["unit_id"];
                $unit_name = $row["unit_name"];
                $course_name = $row["course_name"];

                ?>
        <option value="<?php echo $unit_id ?>"><?php echo "$unit_name - $course_name" ?></option>

        <?php
            }
        }

        ?>




    </select> <br>
    <br>


    <p>Content Name</p>
    <input type="text" value="<?php if (isset($_POST['content_name'])) echo $_POST['content_name']; ?>" name="content_name"> <br><br>

    <p>Content Order</p>
    <input type="number" min="1" name="content_num"> <br><br>

    <p>Content Type</p>


    <input type="radio" name="content_type" id="video" onclick="show1();" value="Video">
    <label for="video"> Video </label><br>

    <input type="radio" name="content_type" id="slide" onclick="show1();" value="Slide">
    <label for="slide"> Slide </label><br>

    <input type="radio" name="content_type" id="pdf" onclick="show2();" value="PDF">
    <label for="pdf"> PDF </label><br>

    <!-- <select name="content_type"><br>

        <option value="Video">Video</option>
        <option value="Slide">Slide</option>
        <option value="PDF">PDF</option>

    </select> <br>
    <br> -->


    <div id="content_code">
        <label for="content_code">Content Source Code</label><br>
        <textarea name="content_code" cols="30" rows="10"></textarea> <br>
    </div>

    <br>
    <div id="content_file">
        <label for="content_file">Content File</label><br>
        <input type="file" name="content_file">
    </div>
    <br>
    <br>

    <input type="submit" name="add_content" value="Add_content">


</form>
<br>
<br>
<div class="container">
    <?php if ($file_error == 0) {
        ?>
    <div class="alert alert-success" role="alert">
        Content Uploaded.
    </div>
    <?php

    }
    ?>
    <?php if ($file_error == 1) {
        ?>
    <div class="alert alert-danger" role="alert">
        File is not a document.
    </div>
    <?php

    }
    ?>
    <?php if ($file_error == 2) {
        ?>
    <div class="alert alert-danger" role="alert">
        Sorry, file already exists.
    </div>
    <?php

    }
    ?>
    <?php if ($file_error == 3) {
        ?>
    <div class="alert alert-danger" role="alert">
        Sorry, your file is too large.
    </div>
    <?php

    }
    ?>
    <?php if ($file_error == 4) {
        ?>
    <div class="alert alert-danger" role="alert">
        Sorry, only PDF files are allowed.
    </div>
    <?php

    }
    ?>
    <?php if ($file_error == 5) {
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
        Content Successfully added.
    </div>
    <?php

    }
    ?>

    <?php if ($error == 1) {
        ?>
    <div class="alert alert-danger" role="alert">
        Content could not be added successfully.
    </div>
    <?php

    }
    ?>
</div>

<script>
    function show1() {
        document.getElementById('content_file').style.display = 'none';
        document.getElementById('content_code').style.display = 'block';
    }

    function show2() {
        document.getElementById('content_file').style.display = 'block';
        document.getElementById('content_code').style.display = 'none';
    }
</script>