<?php
require 'api-google/vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setAuthConfig('service-auth.json');
$client->setAccessType('offline');
$client->setPrompt('select_account consent');
$client->addScope(Google_Service_Drive::DRIVE_FILE);
$client->setRedirectUri('http://localhost/amondocorre/Album3/oauth2callback.php'); // pon tu URL aquí

if (!isset($_GET['code'])) {
    // Redirigir a Google login
    $authUrl = $client->createAuthUrl();
    header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
    exit();
} else {
    // Intercambiar el código por token
    $accessToken = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    var_dump ('token',$accessToken);
    exit();
    // Guardar token en archivo
    if (!file_exists('token.json')) {
        file_put_contents('token.json', json_encode($accessToken));
    }

    // Redirigir al script principal
    header('Location: upload.php');
    exit();
}
