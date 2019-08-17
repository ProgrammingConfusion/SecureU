



<?php
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

    echo "$email";
    echo "$name";

    //run select query to check if email already in db

    //if it exists assign all db data to session variables and redirect to homepage

    //if it does not exist, insert it into the database, and then run the same select query as above,
    //assign values to session variables then redirect to homepage

    // now you can use this profile info to create account in your website and make user logged in.
} else {
    echo "<a href='" . $client->createAuthUrl() . "'>Google Login</a>";
}
?>