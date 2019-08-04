<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
}

if (isset($_GET["course_id"]) && isset($_GET["unit_id"])) {
    $course_id = $_GET["course_id"];
    $unit_id = $_GET["unit_id"];
}
require "db_connect.php";

$sql = "SELECT * FROM `content` WHERE unit_id = $unit_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        $content_name = $row["content_name"];
    }
} else {
    echo "0 results";
}
$page_title = "$content_name";

// Code for page goes here



$result = mysqli_query($conn, $sql);



include "header.php";
?>
<!-- page specific styling goes here -->

<?php include "navbar.php"; ?>

<!-- content for the page starts here -->
<?php
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        $content_id = $row["content_id"];
        $content_name = $row["content_name"];
        $content_num = $row["content_num"];
        $content_type = $row["content_type"];
        $content_code = $row["content_code"];
        ?>
        <h1><?php echo $content_name; ?></h1>

        <p><?php echo $content_code; ?> </p>

    <?php
    }
} else {
    echo "0 results";
}
?>