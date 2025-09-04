<?php
// Mostrar solo errores y fatales, no warnings ni deprecated
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED);
ini_set('display_errors', 1);

require_once 'config.php';

$tokenPath = 'token.json';

// Si ya existe el token en archivo, cargarlo
if (file_exists($tokenPath)) {
    $accessToken = json_decode(file_get_contents($tokenPath), true);
    $client->setAccessToken($accessToken);
}

// Si no hay token aún (primera vez), pedir autorización
if (!$client->getAccessToken()) {
    // Generar URL para autorizar en Google
    $authUrl = $client->createAuthUrl();
    echo "Abre este enlace en tu navegador y autoriza la aplicación:<br>";
    echo "<a href='" . $authUrl . "' target='_blank'>" . $authUrl . "</a><br><br>";
    
    // Capturar el código devuelto por Google
    if (isset($_GET['code'])) {
        $accessToken = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        
        // Guardar token en archivo
        file_put_contents($tokenPath, json_encode($accessToken));
        echo "Token guardado en token.json ✅. Refresca la página.";
        exit;
    } else {
        exit("Falta el parámetro 'code'. Autoriza primero en el enlace.");
    }
}

// Si el token ya existe pero está expirado, refrescarlo
if ($client->isAccessTokenExpired()) {
    if ($client->getRefreshToken()) {
        $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        // Guardar el nuevo token en archivo
        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    }
}

// Ahora ya puedes usar Google Drive
$drive = new Google_Service_Drive($client);

$content = file_get_contents('albaca.png');
$fileMetadata = new Google_Service_Drive_DriveFile([
    'name' => 'archivo_subido1.jpg',
    'parents' => ['10hfNUAOhn447PWncg73iuhay7QO9Iz0E'] // carpeta destino
]);

$file = $drive->files->create($fileMetadata, [
    'data' => $content,
    'mimeType' => 'image/jpeg',
    'uploadType' => 'multipart'
]);

echo "Archivo subido con ID: " . $file->id;
