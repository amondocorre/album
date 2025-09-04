<?php
require 'db.php';

$id = $_POST['id'];
$tipo = $_POST['tipo'];

if ($tipo == "like") {
    $conn->query("UPDATE media SET likes = likes+1 WHERE id=$id");
} else {
    $conn->query("UPDATE media SET corazones = corazones+1 WHERE id=$id");
}

$res = $conn->query("SELECT likes, corazones FROM media WHERE id=$id");
echo json_encode($res->fetch_assoc());
