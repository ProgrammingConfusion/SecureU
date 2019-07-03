<?php

$pagetitle = 'Registration';

include "header.php";

?>

<?php if (isset($_POST["registration"])) {
    echo "registered";
} ?>

<h1>Registration</h1>

<form action="registration.php" method="post">

    Email <br>
    <input type="email" name="email"> <br>

    Username <br>
    <input type="text" name="username"><br>

    Password <br>
    <input type="password" name="password"><br>

    Confirm Password <br>
    <input type="password" name="confirm_password"><br>

    First Name <br>
    <input type="text" name="first_name"><br>

    Last Name <br>
    <input type="text" name="last_name"><br>
    <br>


    Register as a
    <select name="user_role">
        <option value="student">Student</option>
        <option value="teacher">Teacher</option>
    </select><br>

    <input type="submit" name="registration" value="Register">

</form>




<?php include "footer.php"; ?>