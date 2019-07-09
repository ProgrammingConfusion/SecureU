<?php
session_start();





include "header.php";
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
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
</body>

</html>

<?php
include "footer.php";
?>