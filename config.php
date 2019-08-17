<?php

session_start();
require_once "GoogleAPI/vendor/autoload.php";
$g_client = new Google_Client();
$g_client->setClientId("552222869865-4b834ptf5t54sno2kfroocmlntvbc4k5.apps.googleusercontent.com");
$g_client->setClientSecret("ZuD7CZb7ywqFvE4ZJ3qPt1DU");
$g_client->setApplicationName("SecureU");
$g_client->setRedirectUri("http://localhost/SecureU/g_callback.php");
