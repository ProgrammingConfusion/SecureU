<?php
if (isset($_SESSION["user_id"])) {
    ?>
    <p>Logged in as <?php

                    echo $_SESSION["username"] . " " . $_SESSION["user_role"];
                }
                ?>

    <br>
    <a href="logout.php">Logout</a>

    </body>
    <script src="bootstrap/js/bootstrap.min.js"></script>

    </html>