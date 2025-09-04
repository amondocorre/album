<?php
require_once 'config.php';

$tokenPath = 'token.json';

if (isset($_GET['code'])) {
    // Intercambiar el "code" por access_token + refresh_token
    $accessToken = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    // Verificar si vino refresh_token
    if (!isset($accessToken['refresh_token'])) {
        exit("⚠️ No llegó refresh_token. Vuelve a autorizar con prompt=consent & access_type=offline");
    }

    // Guardar en archivo JSON
    file_put_contents($tokenPath, json_encode($accessToken));

    echo "✅ Token guardado en token.json<br>";
    echo "Ya puedes cerrar esta ventana y volver al script de subir archivos.";
} else {
    echo "No se recibió ningún code en la URL.";
}
