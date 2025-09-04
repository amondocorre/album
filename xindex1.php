<?php

require 'api-google/vendor/autoload.php';

putenv('GOOGLE_APPLICATION_CREDENTIALS=service-account.json');

$client = new Google_Client();
$client->useApplicationDefaultCredentials();
// Cambié el scope para acceso más amplio
$client->setScopes(['https://www.googleapis.com/auth/drive']);

try {
    $service = new Google_Service_Drive($client);

    $file_path = 'albaca.png';

    $file = new Google_Service_Drive_DriveFile();
    $file->setName("albaca.png");
    // Asegúrate que este ID sea el de la carpeta compartida
    $file->setParents(["10hfNUAOhn447PWncg73iuhay7QO9Iz0E"]);
    $file->setDescription("Archivo cargado desde PHP");
    $file->setMimeType("image/png");

    // Subir archivo
    $resultado = $service->files->create(
        $file,
        [
            'data' => file_get_contents($file_path),
            'mimeType' => 'image/png',
            'uploadType' => 'multipart'
        ]
    );

    echo '<a href="https://drive.google.com/open?id=' . $resultado->id . '" target="_blank">' . $resultado->name . '</a>';

} catch (Google_Service_Exception $gs) {
    $mensaje = json_decode($gs->getMessage());
    echo $mensaje->error->message;
} catch (Exception $e) {
    echo $e->getMessage();
}




/*require 'api-google/vendor/autoload.php';

putenv('GOOGLE_APPLICATION_CREDENTIALS=service-account.json');

$client = new Google_Client();
$client->useApplicationDefaultCredentials();
//$client->setScopes(['https://www.googleapis.com/auth/drive.file']);
$client->setScopes(['https://www.googleapis.com/auth/drive']);

try {
    $service = new Google_Service_Drive($client);

    $file_path = 'albaca.png';

    $file = new Google_Service_Drive_DriveFile();
    $file->setName("albaca.png");
    $file->setParents(["10hfNUAOhn447PWncg73iuhay7QO9Iz0E"]);
    $file->setDescription("Archivo cargado desde PHP");
    $file->setMimeType("image/png");

    // Subir archivo
    $resultado = $service->files->create(
        $file,
        [
            'data' => file_get_contents($file_path),
            'mimeType' => 'image/png',
            'uploadType' => 'multipart'
        ]
    );

    echo '<a href="https://drive.google.com/open?id=' . $resultado->id . '" target="_blank">' . $resultado->name . '</a>';

} catch (Google_Service_Exception $gs) {
    $mensaje = json_decode($gs->getMessage());
    echo $mensaje->error->message;
} catch (Exception $e) {
    echo $e->getMessage();
}
    */

?>
