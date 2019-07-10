<?php
session_start();





include "header.php";
?>




<?php


if (isset($_SESSION["user_id"])); {

    $first_name = $_SESSION["first_name"];
    $last_name = $_SESSION["last_name"];
    ?>

    <h2>Welcome back, <?php echo "$first_name $last_name"; ?> </h2>

<?php

}

?>

<a href="logout.php">Logout</a>

<?php
include "footer.php";
?>