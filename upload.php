<?php
require_once 'config.php';
require_once 'db.php';
require_once 'cloudinary_config.php';

// 🔹 Ocultar warnings y notices feos
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

// Datos del formulario
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';

$errores = []; // Para almacenar mensajes de error

if (!empty($_FILES['archivo']['name'][0])) {

    foreach ($_FILES['archivo']['tmp_name'] as $key => $tmp_name) {

        $archivo_nombre = $_FILES['archivo']['name'][$key];
        $archivo_tmp    = $_FILES['archivo']['tmp_name'][$key];
        $archivo_tipo   = $_FILES['archivo']['type'][$key];
        $errorCode      = $_FILES['archivo']['error'][$key];

        // 🔹 Validar errores de subida
        if ($errorCode !== UPLOAD_ERR_OK) {
            switch ($errorCode) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    $errores[] = "El archivo <strong>{$archivo_nombre}</strong> es demasiado grande. Límite permitido: 200MB.";
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $errores[] = "No se seleccionó ningún archivo.";
                    break;
                default:
                    $errores[] = "Error al subir el archivo <strong>{$archivo_nombre}</strong>.";
            }
            continue; // Saltar este archivo
        }

        // 🔹 Determinar tipo
        $tipo = (strpos($archivo_tipo, 'video') !== false) ? 'video' : 'foto';

        // 🔹 Subir a Cloudinary
        try {
            $result = $cloudinary->uploadApi()->upload($archivo_tmp, [
                'folder' => 'graduacion',
                'resource_type' => $tipo == 'video' ? 'video' : 'image'
            ]);

            $cloudinaryUrl = $result['secure_url'];

            // 🔹 Guardar en BD
            $stmt = $conn->prepare("INSERT INTO media (nombre, descripcion, tipo, cloudinary_url) VALUES (?,?,?,?)");
            $stmt->bind_param("ssss", $nombre, $descripcion, $tipo, $cloudinaryUrl);
            $stmt->execute();

        } catch (Exception $e) {
            $errores[] = "Error subiendo el archivo <strong>{$archivo_nombre}</strong>: " . $e->getMessage();
        }
    }

    // 🔹 Mostrar alertas si hubo errores
    if (!empty($errores)) {
        foreach ($errores as $error) {
            echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
        }
        echo '<a href="index.php" class="btn btn-primary mt-3">Volver</a>';
        exit;
    }

    // 🔹 Si todo salió bien, redirigir
    header("Location: index.php");
    exit;

} else {
    echo '<div class="alert alert-warning" role="alert">No se seleccionaron archivos.</div>';
    echo '<a href="index.php" class="btn btn-primary mt-3">Volver</a>';
}
