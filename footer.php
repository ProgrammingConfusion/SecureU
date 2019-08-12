<?php
if (isset($_SESSION["user_id"])) {
    ?>
    <p>Logged in as <?php

                    echo $_SESSION["username"] . " " . $_SESSION["user_role"];
                }
                ?>

    <br>
    <a href="logout.php">Logout</a>

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>