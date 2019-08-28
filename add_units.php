<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
}

$page_title = "Add Unit";



$error = "9";

if (isset($_POST["create_unit"])) {

    require "db_connect.php";

    $user_id = $_SESSION["user_id"];

    $course_id = mysqli_real_escape_string($conn, trim($_POST["course_id"]));
    $unit_name = mysqli_real_escape_string($conn, trim($_POST["unit_name"]));
    $unit_num = mysqli_real_escape_string($conn, trim($_POST["unit_num"]));
    $unit_desc = mysqli_real_escape_string($conn, trim($_POST["unit_desc"]));

    $sql = "INSERT INTO `units` (`unit_id`, `unit_name`, `unit_num`, `unit_desc`, `course_id`, `user_id`)
     VALUES (NULL, '$unit_name', '$unit_num', '$unit_desc', '$course_id', '$user_id');";

    if (mysqli_query($conn, $sql)) {
        $error = "0";
    } else {
        $error = "1";
    }
}




include "header.php"; ?>

<?php include "navbar.php"; ?>

<div class="container">
    <div class="row">
        <div class="col-md-6 col-lg-6 mx-auto">
            <?php if ($error == 1) {
                ?>
            <div class="alert alert-danger" role="alert">
                Unit creation Failed
            </div>
            <?php

            }
            ?>

            <?php if ($error == 0) {
                ?>
            <div class="alert alert-success" role="alert">
                Unit Creation Successful!
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
                    <h1>Add Unit</h1>
                </div>

                <form action="add_units.php" method="post" class="form-validate form-horizontal well">
                    <fieldset>
                        <legend>Add your unit here!</legend>

                        <div class="form-group">
                            <label for="">Select Course:</label>
                            <select class="form-control" name="course_id" id="">
                                <?php

                                require "db_connect.php";

                                $user_id = $_SESSION["user_id"];

                                $sql = "SELECT * FROM courses WHERE user_id=$user_id";
                                $result = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($result) > 0) {
                                    // output data of each row
                                    while ($row = mysqli_fetch_assoc($result)) {

                                        $course_id = $row["course_id"];
                                        $course_name = $row["course_name"];

                                        ?>
                                <option value="<?php echo $course_id ?>"><?php echo $course_name ?></option>

                                <?php
                                    }
                                }

                                ?>


                            </select></div> <br>
                        <div class="form-group">
                            <label for="unit_name">Unit Name</label>
                            <input type="text" class="form-control" placeholder="Enter Unit Name" name="unit_name" id="unit_name" required>
                        </div>

                        <div class="form-group">
                            <label for="unit_num">Unit Number *</label>
                            <input type="number" min="1" name="unit_num" placeholder="Enter Unit Number" id="unit_num" class="form-control"> <br>
                        </div>

                        <div id="unit_desc" class="form-group">
                            <label for="unit_desc">Unit Description</label>
                            <textarea name="unit_desc" id="unit_desc" class="form-control" cols="30" rows="10"></textarea> <br>
                        </div>

                        <div class="form-group d-flex justify-content-start">
                            <input type="submit" class="btn btn-primary" name="create_unit" value="Create Unit">
                        </div>


            </div>
            <br>
            <br>
            <br>
            <div>Now Add some content to your unit <a class="btn btn-primary" href="add_content.php">Add Content</a> </div>
            </fieldset>
            </form>
        </div>
    </div>
</div>
</div>
<form>










    <?php include "footer.php"; ?>