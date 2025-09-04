<?php
require_once 'api-google/vendor/autoload.php';

$client = new Google_Client();
$client->setClientId('536228830295-nbih4ih9kb17oh7pnjtgosq6ija6n3gq.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/amondocorre/Album3/oauth2callback.php');
$client->addScope(Google_Service_Drive::DRIVE_FILE);
$client->setAccessType('offline');
$client->setPrompt('consent');