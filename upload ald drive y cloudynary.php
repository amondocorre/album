<?php
require_once 'config.php';
require_once 'db.php';
require_once 'cloudinary_config.php';

$tokenPath = 'token.json';
if (file_exists($tokenPath)) {
    $client->setAccessToken(json_decode(file_get_contents($tokenPath), true));
}
if ($client->isAccessTokenExpired()) {
    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
    file_put_contents($tokenPath, json_encode($client->getAccessToken()));
}
$drive = new Google_Service_Drive($client);

// Datos del formulario
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];

if (!empty($_FILES['archivo']['name'][0])) {

    foreach ($_FILES['archivo']['tmp_name'] as $key => $tmp_name) {

        $archivo_nombre = $_FILES['archivo']['name'][$key];
        $archivo_tmp    = $_FILES['archivo']['tmp_name'][$key];
        $archivo_tipo   = $_FILES['archivo']['type'][$key];

        $tipo = (strpos($archivo_tipo,'video') !== false) ? 'video' : 'foto';

        // 🔹 Subir a Google Drive
        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => basename($archivo_nombre),
            'parents' => ['10hfNUAOhn447PWncg73iuhay7QO9Iz0E']
        ]);
        $content = file_get_contents($archivo_tmp);
        $file = $drive->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => $archivo_tipo,
            'uploadType' => 'multipart'
        ]);
        $driveId = $file->id;

        // Hacer público en Drive
        $permission = new Google_Service_Drive_Permission();
        $permission->setType('anyone');
        $permission->setRole('reader');
        $drive->permissions->create($driveId, $permission);

        // 🔹 Subir a Cloudinary desde Drive (más eficiente)
        $publicUrl = "https://drive.google.com/uc?export=view&id=$driveId";

        $result = $cloudinary->uploadApi()->upload($publicUrl, [
            'folder' => 'graduacion',
            'resource_type' => $tipo=='video' ? 'video' : 'image'
        ]);

        $cloudinaryUrl = $result['secure_url']; // URL pública para <img>


        // Guardar en BD
        $stmt = $conn->prepare("INSERT INTO media (nombre, descripcion, tipo, drive_id, cloudinary_url) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss", $nombre, $descripcion, $tipo, $driveId, $cloudinaryUrl);
        $stmt->execute();
    }

    header("Location: index.php");
} else {
    echo "No se seleccionaron archivos.";
}
