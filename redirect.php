



<?php

session_start();
require_once 'google_client/vendor/autoload.php';

// init configuration
$clientID = '68618636083-cvdh6ltt1k34da05h0ghlb58rkath6hc.apps.googleusercontent.com';
$clientSecret = 'd8lAMCD4mwgvC_W3hgoI_Nx5';
$redirectUri = 'http://localhost/SecureU/redirect.php';

// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    // get profile info
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    $email =  $google_account_info->email;
    $name =  $google_account_info->name;


    //var_dump(get_object_vars($google_oauth));

    $username = strstr("$email", "@", true);

    //run select query to check if email already in db
    require "db_connect.php";


    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            //if it exists assign all db data to session variables and redirect to homepage
            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["first_name"] = $row["first_name"];
            $_SESSION["last_name"] = $row["last_name"];
            $_SESSION["username"] = $row["username"];
            $_SESSION["email"] = $row["email"];
            $_SESSION["user_role"] = $row["user_role"];
            header("location: homepage.php");
        }
    } else {

        //if it does not exist, insert it into the database, and then run the same select query as above,
        $sql = "INSERT INTO `users` (`user_id`, `email`, `username`, `password`, `first_name`, `last_name`, `user_dob`, `user_role`, `reg_date`)
        VALUES (NULL, '$email', '$username', '', '$name', '', '', 'student', CURRENT_TIMESTAMP);";

        if (mysqli_query($conn, $sql)) {
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while ($row = mysqli_fetch_assoc($result)) {
                    //assign values to session variables then redirect to homepage
                    $_SESSION["user_id"] = $row["user_id"];
                    $_SESSION["first_name"] = $row["first_name"];
                    $_SESSION["last_name"] = $row["last_name"];
                    $_SESSION["username"] = $row["username"];
                    $_SESSION["email"] = $row["email"];
                    $_SESSION["user_role"] = $row["user_role"];
                    header("location: homepage.php");
                }
            }
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }






    // now you can use this profile info to create account in your website and make user logged in.
} else {
    echo "<a href='" . $client->createAuthUrl() . "'>Google Login</a>";
    $_SESSION["test"] = "<a href='" . $client->createAuthUrl() . "'>Google Login</a>";
}
?>