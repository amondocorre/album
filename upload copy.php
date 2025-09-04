<?php
//error_reporting(E_ALL & ~E_WARNING);

require_once 'config.php';

// 1 desbloquear para obtener un token
session_start();
$client->setAccessToken($_SESSION['access_token']??'');

/*
// desbloquear cuando se tene el token
 $client->setAccessToken('"ya29.A0AS3H6NwItH1toPYpMHeOpenab8UyWBV1BsYwzLujTaWtQhTbjOsMa8_5z4GVxOCSGIIfdRqY9Z0X7nN_rNCs6wLJej31V56Kq4aihCsEHKlUOh9rq8BexIXw0GiF8xv5WR6TkUjtysXGOlRv6ACb83fsgU_zlSLiQn8hSJCB-9sPMJ_li70CgtpVuIt5fLaFDLluMWYaCgYKAVkSARYSFQHGX2MiySRBLLOiWKY-8TOVAGFq_A0206" ["expires_in"]=> int(3599) ["refresh_token"]=> string(103) "1//0haktrRX5LEN-CgYIARAAGBESNwF-L9Ir5_XBB59guX7vD0zCfG8uhV8Qi5m-G5yhaJ_wrpfbUQdnX_GnwtcWyTUPr2-yvRqXGB0" ["scope"]=> string(42) "https://www.googleapis.com/auth/drive.file" ["token_type"]=> string(6) "Bearer" ["created"]=> int(1756415584)');
*/
var_dump($_SESSION['access_token']);

$drive = new Google_Service_Drive($client);

$content = file_get_contents('albaca.png');
//var_dump('texto',$content);
$fileMetadata = new Google_Service_Drive_DriveFile([
    'name' => 'archivo_subido.jpg',
    'parents' => ['10hfNUAOhn447PWncg73iuhay7QO9Iz0E']
]);

//$content = file_get_contents('albaca.png');

$file = $drive->files->create($fileMetadata, [
    'data' => $content,
    'mimeType' => 'image/jpeg',
    'uploadType' => 'multipart'
]);

echo "Archivo subido con ID: " . $file->id;