<?php
require 'api-google/vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setAuthConfig('service-auth.json'); // archivo de credenciales descargado
$client->setAccessType('offline'); // importante para refrescar el token
$client->setPrompt('select_account consent');
$client->addScope(Google_Service_Drive::DRIVE_FILE);

// Cargar token si ya existe
if (file_exists('token.json')) {
    $accessToken = json_decode(file_get_contents('token.json'), true);
    $client->setAccessToken($accessToken);

    // Si el token expiró, refrescarlo
    if ($client->isAccessTokenExpired()) {
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            file_put_contents('token.json', json_encode($client->getAccessToken()));
        } else {
            // Si no hay refresh token, pedir login de nuevo
            header('Location: oauth2callback.php');
            exit();
        }
    }
} else {
    // No hay token → pedir login
    header('Location: oauth2callback.php');
    exit();
}

// Si ya tenemos token válido → subir archivo
$service = new Google_Service_Drive($client);

$fileMetadata = new Google_Service_Drive_DriveFile([
    'name' => 'albaca.png',
    // opcional: si quieres dentro de una carpeta, pon aquí el ID
    // 'parents' => ['TU_FOLDER_ID']
]);

$content = file_get_contents('albaca.png');

$file = $service->files->create($fileMetadata, [
    'data' => $content,
    'mimeType' => 'image/png',
    'uploadType' => 'multipart',
    'fields' => 'id'
]);

echo "✅ Archivo subido: <a href='https://drive.google.com/open?id=" . $file->id . "' target='_blank'>Ver en Drive</a>";
