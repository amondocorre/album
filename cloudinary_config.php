<?php
require __DIR__ . '/api-google/vendor/autoload.php'; // Carga la librería de Cloudinary

use Cloudinary\Cloudinary;

$cloudinary = new Cloudinary([
    'cloud' => [
        'cloud_name' => 'dq3touuoa',
        'api_key'    => '326456852961596',
        'api_secret' => 'ILYIFlMEmNwtIf_Nhb7AHTzegTE',
    ],
    'url' => [
        'secure' => true
    ]
]);
