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
    section {
        padding-top: 4rem;
        padding-bottom: 5rem;
        background-color: #f1f4fa;
    }

    .wrap {
        display: flex;
        background: white;
        padding: 1rem 1rem 1rem 1rem;
        border-radius: 0.5rem;
        box-shadow: 7px 7px 30px -5px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .wrap:hover {
        background: linear-gradient(135deg, #6394ff 0%, #0a193b 100%);
        color: white;
    }

    .ico-wrap {
        margin: auto;
    }

    .mbr-iconfont {
        font-size: 4.5rem !important;
        color: #313131;
        margin: 1rem;
        padding-right: 1rem;
    }

    .vcenter {
        margin: auto;
    }

    .mbr-section-title3 {
        text-align: left;
    }

    h2 {
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .display-5 {
        font-family: 'Source Sans Pro', sans-serif;
        font-size: 1.4rem;
    }

    .mbr-bold {
        font-weight: 700;
    }

    p {
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
        line-height: 25px;
    }

    .display-6 {
        font-family: 'Source Sans Pro', sans-serif;
        font-size: 1re
    }

    a {
        color: inherit;
    }
</style>

<?php
include "navbar.php";
?>
<section>
    <div class="container">


        <div class="row mbr-justify-content-center">


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
                    $course_link = "units.php?course_id=$course_id";
                    ?>

                    <div class="col-lg-6 mbr-col-md-10">

                        <a style="text-decoration:none" href="<?php echo $course_link; ?>">
                            <div class="wrap">

                                <div class="ico-wrap">
                                    <span class="fas fa-5x mr-5 fa-user-shield"></span>
                                </div>
                                <div class="text-wrap vcenter">
                                    <h2 class="mbr-fonts-style mbr-bold mbr-section-title3 display-5"><?php echo $course_name; ?></span></h2>
                                    <p class="mbr-fonts-style text1 mbr-text display-6"><?php echo $course_desc; ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php
                }
            } else {
                echo "0 results";
            }

            ?>








        </div>

    </div>

</section>







<?php
include "footer.php"
?>