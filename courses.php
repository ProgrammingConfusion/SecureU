<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
}

$page_title = "Courses";

include "header.php";

?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

<style>
    .box20,
    .box20 .icon li a {
        overflow: hidden
    }

    .box20 {
        box-shadow: 0 0 5px #a3a3a3
    }

    .box20 .post,
    .box20 .title {
        text-transform: capitalize;
        width: 60%;
    }

    .box20 {
        position: relative
    }

    .box20:after,
    .box20:before {
        position: absolute;
        content: ""
    }

    .box20:before {
        width: 80%;
        height: 220%;
        background: #0062b2;
        top: -50%;
        left: -100%;
        z-index: 1;
        transform: rotate(25deg);
        transform-origin: center top 0;
        transition: all .5s ease 0s
    }

    /*.box20.blue:before{background:#0062b2!important;}
.box20.red:before{background:#b31d23!important;}
.box20.yellow:before{background:#efc203!important;}*/
    .box20:hover:before {
        left: 10%
    }

    .box20:after {
        width: 55%;
        height: 175%;
        background-color: rgba(0, 0, 0, .35);
        bottom: -1000%;
        left: 53%;
        transform: rotate(-33deg);
        transform-origin: center bottom 0;
        transition: all .8s ease 0s
    }

    .box20 .box-content,
    .box20 .icon {
        width: 100%;
        padding: 0 20px;
        position: absolute;
        left: 0;
        z-index: 2;
        transition: all 1.1s ease 0s
    }

    .box20:hover:after {
        bottom: -70%
    }

    .box20 img {
        width: 100%;
        height: auto
    }

    .box20 .box-content {
        top: -100%;
        color: #fff
    }

    .box20:hover .box-content {
        top: 30px
    }

    .box20 .title {
        font-size: 20px;
        margin: 0
    }

    .box20 .icon li a,
    .box20 .post {
        display: inline-block;
        font-size: 14px
    }

    .box20 .post {
        margin-top: 5px
    }

    .box20 .icon {
        list-style: none;
        margin: 0;
        bottom: -100%
    }

    .box20:hover .icon {
        bottom: 25px
    }

    .box20 .icon li {
        display: inline-block
    }

    .box20 .icon li a {
        width: 35px;
        height: 35px;
        line-height: 35px;
        background: #ff0000;
        border-radius: 50%;
        margin: 0 3px;
        color: #fff;
        text-align: center;
        transition: all .5s ease 0s
    }

    .box20 .icon li a:hover {
        background: #fff;
    }

    .box20 .button {
        background-color: #8e909b;
        border-radius: 3px;
        display: inline-block;
        padding: 6px 12px;
        margin-top: 10px;
    }

    .box20 .button:hover {
        background-color: #000000;
    }

    .box20 a,
    box20 a:link,
    box20 a:visited,
    box20 a:hover,
    box20 a:active {
        color: #ffffff !important;
    }

    .icon {
        display: inline-block;
        height: 60px;
        width: auto;
    }

    .fas {
        font-size: 32px;
        background-color: rgba(0, 0, 0, .1);
        border-radius: 100px;
        height: 55px;
        width: 55px;
        line-height: 55px;
        display: inline-block;
        vertical-align: middle;
        text-align: center;
    }

    .circle-icon {
        background: rgba(0, 0, 0, .1);
        width: 66px;
        height: 66px;
        border-radius: 50%;
        text-align: center;
        line-height: 50px;
        vertical-align: middle;
        padding: 15px;
    }

    h2.sector {
        font-size: 26px;
        color: #555555;
    }

    .box20 {
        margin-bottom: 36px;
    }

    @media only screen and (max-width:990px) {
        .box20 {
            margin-bottom: 30px
        }

        .box20 .title {
            font-size: 16px
        }
    }

    @media only screen and (max-width:479px) {
        .box20 .title {
            font-size: 16px
        }
    }

    .img {
        position: relative;
        float: left;
        width: 500px;
        height: 300px;
        background-position: 50% 50%;
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>

<?php
include "navbar.php";
?>

<div class="container mt-40">
    <h3 class="text-center">Courses</h3>
    <div class="row mt-30">
        <?php

        require "db_connect.php";

        $sql = "SELECT * FROM courses";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while ($row = mysqli_fetch_assoc($result)) {

                $course_id = $row["course_id"];
                $course_name = $row["course_name"];
                $course_desc = $row["course_desc"];
                $course_img = $row["course_img"];
                $course_link = "units.php?course_id=$course_id";
                ?>


        <div class="col-sm-12 col-md-6">
            <div class="box20 red img">
                <img src="<?php echo $course_img; ?>" alt="course image">
                <div class="box-content">
                    <i class="fas fa-user-shield circle-icon"></i>
                    <h3 class="title text-dark"><?php echo $course_name; ?></h3>
                    <h3 class="title"> <?php echo $course_desc; ?></h3>
                    <p><a class="button" href="<?php echo $course_link; ?>">Begin Course</a></p>
                </div>
            </div>
        </div>



        <?php
            }
        } else {
            echo "0 results";
        }

        ?>









    </div>
</div>






<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<?php
include "footer.php"
?>