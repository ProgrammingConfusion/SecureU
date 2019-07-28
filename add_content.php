<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
}

$page_title = "Add Content";


if (isset($_POST["add_content"])) {
    require "db_connect.php";

    $unit_id = mysqli_real_escape_string($conn, trim($_POST["unit_id"]));
    $content_name = mysqli_real_escape_string($conn, trim($_POST["content_name"]));
    $content_num = mysqli_real_escape_string($conn, trim($_POST["content_num"]));
    $content_type = mysqli_real_escape_string($conn, trim($_POST["content_type"]));
    $content_code = mysqli_real_escape_string($conn, trim($_POST["content_code"]));


    $sql = "INSERT INTO `content` (`content_id`, `content_name`, `content_num`, `content_type`, `content_code`, `unit_id`)
     VALUES (NULL, '$content_name', '$content_num', '$content_type', '$content_code', '$unit_id');";

    if (mysqli_query($conn, $sql)) {
        echo "New content added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}




include "header.php";
?>

<?php include "navbar.php"; ?>

<form action="add_content.php" method="post">

    <p>Unit ID</p>
    <input type="number" name="unit_id" required> <br>

    <p>Content Name</p>
    <input type="text" name="content_name"> <br>

    <p>Content Order</p>
    <input type="number" name="content_num"> <br>

    <p>Content Type</p>
    <select name="content_type">

        <option value="video">Video</option>
        <option value="image">Image</option>
        <option value="document">Document</option>

    </select>

    <p>Content Source Code</p>
    <textarea name="content_code" cols="30" rows="10"></textarea> <br>

    <input type="submit" name="add_content" value="Add_content">


</form>
<?php
include "footer.php";
?>