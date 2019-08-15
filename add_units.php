<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
}

$page_title = "Add Unit";





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
        echo "New Unit created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}




include "header.php"; ?>

<?php include "navbar.php"; ?>

<h2> Create Unit</h2>

<form action="add_units.php" method="post">

    Course ID <br>
    <select name="course_id" placeholder="Select Course ID">
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




    </select> <br>

    Unit Name <br>
    <input type="text" name="unit_name" placeholder="Enter Unit Name"> <br>
    <br>

    Unit Number <br>
    <input type="number" min="1" name="unit_num" placeholder="Enter Unit Number"> <br>
    <br>

    Unit Description <br>
    <input type="text" name="unit_desc" placeholder="Enter Unit Description"> <br>
    <br>



    <input type="submit" name="create_unit" value="Create Unit">


</form>










<?php include "footer.php"; ?>