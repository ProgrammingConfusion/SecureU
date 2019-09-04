<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
}

$page_title = "Q&A Forum";


// Code for page goes here
$redirect = 1;

if (isset($_GET["course_id"]) && isset($_GET["unit_id"])) {
    $course_id = $_GET["course_id"];
    $unit_id = $_GET["unit_id"];
    $_SESSION["course_id"] = $course_id;
    $_SESSION["unit_id"] = $unit_id;
} else {
    header("location: forum_search.php");
}




if (isset($_POST["create_post"])) {

    require "db_connect.php";
    $post_name = mysqli_real_escape_string($conn, trim($_POST["post_name"]));
    $post_content = mysqli_real_escape_string($conn, trim($_POST["post_content"]));
    $unit_id = $_SESSION["unit_id"];
    $user_id = $_SESSION["user_id"];



    $sql = "INSERT INTO `forum` (`post_id`, `post_name`, `post_content`, `post_date`, `post_credits`, `unit_id`, `user_id`) 
VALUES (NULL, '$post_name', '$post_content', CURRENT_TIMESTAMP, '', '$unit_id', '$user_id');";

    if (mysqli_query($conn, $sql)) {

        $sql = "UPDATE `users` SET `user_credits` = 1 + user_credits WHERE `users`.`user_id` = $user_id;";

        if (mysqli_query($conn, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }

        header("location: forum.php?course_id=$course_id&unit_id=$unit_id");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

include "header.php";
?>
<!-- page specific styling goes here -->

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<style>
    .require {
        color: #666;
    }

    label small {
        color: #999;
        font-weight: normal;
    }

    body {
        background: #f2f3f8;
        margin-top: 20px;
    }


    .page.has-sidebar.bordered .page-header {
        margin-bottom: 0;
    }

    .page.has-sidebar.bordered .page-inner {
        padding-bottom: 0;
        padding-top: 0px;
    }

    .page.has-sidebar.bordered .left-side-sidebar {
        padding-top: 50px;
        padding-bottom: 50px;
    }

    .page.has-sidebar.bordered .right-side-sidebar {
        padding-top: 50px;
        padding-bottom: 50px;
    }

    .has-sidebar.bordered.has-right-sidebar .left-side-sidebar {
        border-right: 1px solid rgba(0, 0, 0, 0.1) !important;
        box-shadow: 1px 0px 0px 0px rgba(255, 255, 255, 0.715) !important;
        padding-right: 45px;
    }

    .has-sidebar.bordered.has-right-sidebar .right-side-sidebar {
        padding-left: 40px;
    }

    .has-sidebar.bordered.has-left-sidebar .right-side-sidebar {
        padding-left: 45px;
    }

    .has-sidebar.bordered.has-left-sidebar .left-side-sidebar {
        border-right: 1px solid rgba(0, 0, 0, 0.1) !important;
        box-shadow: 1px 0px 0px 0px rgba(255, 255, 255, 0.715) !important;
        padding-right: 40px;
    }

    .page.has-sidebar .left-side-sidebar {
        padding-top: 50px;
        padding-bottom: 50px;
    }

    .page.has-sidebar .page-inner {
        padding-bottom: 0;
        padding-top: 0px;
    }

    .page.has-sidebar .right-side-sidebar {
        padding-top: 50px;
        padding-bottom: 50px;
    }

    /* --------------------------------------------
   SEARCH LIST
 -------------------------------------------- */

    .xsearch-items {
        padding-left: 0px;
    }


    .search-item-img {
        float: left;
        position: relative;
    }

    .search-item-img img,
    .search-item-img .img-holder {
        height: 70px;
        width: 70px;
        display: block;
        -moz-border-radius: 50%;
        -webkit-border-radius: 50%;
        border-radius: 50%;
        box-shadow: 0 1px 3px rgba(50, 50, 93, .15), 0 1px 0 rgba(0, 0, 0, .02);
        border: 4px solid white;
    }

    .search-item-img .img-holder {
        border: 1px solid #e3e3e3;
        line-height: 20px;
        background: #f7f7f7;
        border-color: rgba(207, 215, 223, .25);
    }

    .search-item-img .img-holder i {
        display: inline-block;
        padding: 28px 20px;
        font-size: 28px;
        opacity: 0.5;
    }

    .search-item-content {
        margin-left: 100px;
        padding-bottom: 35px;
        margin-bottom: 20px;
        /*border-bottom: 1px solid rgb(231, 231, 231);*/
    }

    .search-item-content.no-excerpt h3 {
        margin-top: 8px;
    }

    .search-item-content .search-item-meta {
        display: block;
        margin-bottom: 10px;
    }

    .search-item-meta-down a,
    .search-item-meta a {
        font-size: 11px;
        text-transform: uppercase;
    }

    .xsearch-items a:hover {
        border-bottom-width: 1px;
        border-bottom-style: dotted;
    }

    .search-item-content .time {
        color: #999;
        font-size: 11px;
        text-transform: uppercase;
    }

    .search-item-content time,
    .search-item-content span {
        color: #999999;
    }

    .xsearch-items h3.search-item-caption {
        margin-bottom: 2px;
        font-weight: 600;
        font-size: 20px;
    }

    .xsearch-items .search-item-meta-down {
        margin-top: 5px;
        color: #999;
        font-size: 12px;
    }

    .xsearch-items .star-vote li {
        padding: 0;
        font-size: 14px;
    }

    .xsearch-result-count {
        color: #999;
        margin-bottom: 30px;
    }


    ul.xsearch-items-2 {
        padding-left: 0;
        margin-left: 0;
    }

    .xsearch-items-2 li {
        list-style: none;
    }


    .xsearch-info-meta:before,
    .xsearch-info-meta:after {
        content: "";
        display: table;
    }

    .xsearch-info-meta:after {
        clear: both;
    }

    .xsearch-info-meta {
        padding: 0;
        margin: 0;
        list-style-type: none;
        margin-bottom: 5px;
        font-size: 12px;
        opacity: 0.7;
    }

    .xsearch-info-meta-item {
        float: left;
        margin-right: 10px;
    }

    .xsearch-item-title h3,
    .xsearch-item-title h4 {
        margin-bottom: 5px;
    }

    .xsearch-desc {
        margin-bottom: 2px;
    }

    .search-item-icon {
        padding-right: 3px;
    }

    nav.xsearch-navbar {
        padding-left: 0;
    }

    nav.xsearch-navbar.navbar-light .navbar-nav .active>.nav-link {
        border-bottom-width: 2px;
        border-bottom-style: solid;
        padding-bottom: 12px;
    }

    .xsearch-item .xsearch-item-title strong {
        font-weight: 600;
    }

    ul.xsearch-items-2 .xsearch-item {
        margin-bottom: 40px;
    }

    .xsearch-item .xsearch-desc strong {
        color: #111;
    }



    .search-result-wrap .search-result-item {
        padding-bottom: 25px;
        padding-top: 25px;
        border-bottom: 1px solid rgba(207, 215, 223, .25);
    }

    .search-result-wrap .search-result-item .title h4,
    .search-result-wrap .search-result-item .title h3 {
        margin-bottom: 5px;
    }

    .search-result-item-meta {
        font-size: 14px;
        margin-bottom: 10px;
        margin-left: 25px;
    }

    .search-result-item-meta li {
        color: #999;
        margin-right: 5px;
    }

    .search-result-item-meta li i {
        margin-right: 4px;
    }

    .search-result-item-meta li a {
        /*border-bottom:1px dotted rgba(207,215,223,.25);
    padding-bottom:2px;*/
        color: #1a0dab;
    }

    .search-result-item-link,
    .search-result-item-excerpt,
    .search-result-item-meta {
        margin-left: 25px;
    }

    .search-result-item-excerpt strong {
        color: #444;
        font-weight: 600;
    }

    .search-result-item-excerpt {
        margin-bottom: 5px;
    }

    .search-result-item-meta li:first-child {
        margin-left: 0;
        padding-left: 0;
    }
</style>

<!-- <?php include "navbar.php"; ?> -->

<!-- content for the page starts here -->

<div class="container">
    <h1> Q&A Forum</h1>
    <div class="row">
        <?php
        require "db_connect.php";
        require "custom_functions.php";
        //$sql = "SELECT * FROM `forum`";
        $sql = "SELECT * FROM forum, users, units WHERE forum.user_id = users.user_id AND forum.unit_id = units.unit_id AND forum.unit_id = $unit_id";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {

            // output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                $post_id = $row["post_id"];
                $post_name = $row["post_name"];
                $post_content = $row["post_content"];
                $post_date = get_time_ago(strtotime($row["post_date"]));;
                $post_credits = $row["post_credits"];
                $user_id = $row["user_id"];
                $username = $row["username"];
                $user_img = $row["user_img"];
                $unit_name = $row["unit_name"];

                ?>


        <div class="col-md-8 left-side-sidebar">
            <div class="clearfix mt-40">
                <ul class="xsearch-items">
                    <li class="search-item">
                        <div class="search-item-img">

                            <img src="<?php echo $user_img; ?>" width="70" height="70">

                        </div>
                        <div class="search-item-content">
                            <h3 class="search-item-caption"><?php echo $post_name; ?></h3>

                            <div class="search-item-meta mb-15">
                                <ul class="list-inline">
                                    <li class="time"><?php echo $post_date; ?>‎</li>
                                    <li> Posted by: <?php echo $username; ?></li>
                                    <li class="pr-0">in</li>
                                    <li class="pl-0"><?php echo $unit_name; ?></li>
                                </ul>
                            </div>
                            <div>
                                <?php echo $post_content; ?>
                            </div>
                        </div>
                    </li>

            </div>
        </div>


        <?php
            }
        } else {
            ?>
        <div class="col-md-12">
            <div class="v-heading-v2">
                <h4 class="v-search-result-count">No posts yet, make one below!</h4>
            </div>
        </div>
        <?php
        }
        ?>

        <div class="col-md-8 col-md-offset-2">

            <h3>Create post</h3>

            <form action="forum.php" method="POST">


                <div class="form-group">
                    <label for="post_name">Post Title<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Enter post title." name="post_name" required>
                </div>

                <div class="form-group">
                    <label for="post_content">Post<span class="text-danger">*</span></label>
                    <textarea rows="5" class="form-control" placeholder="Post your question or response here." name="post_content" required></textarea>
                </div>

                <div class="form-group">
                    <p><span class="text-danger">*</span> - required fields</p>
                </div>

                <div class="form-group">
                    <input type="submit" name="create_post" value="Post" class="btn btn-primary" required>
                </div>

            </form>
        </div>

    </div>
    <a class="btn btn-primary" href="forum_search.php">Search all posts</a>
</div>


<!-- <?php
        echo $unit_id;
        ?> -->
<?php include "footer.php"; ?>

<!-- page specific scripts go here -->