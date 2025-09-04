<?php
require 'db.php';

header('Content-Type: application/json');

if (!isset($_POST['id'], $_POST['tipo'])) {
    echo json_encode(["error" => "Datos incompletos"]);
    exit;
}

$id = intval($_POST['id']);
$tipo = $_POST['tipo'];

// Verificamos que el id exista
$stmt = $conn->prepare("SELECT id FROM media WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    echo json_encode(["error" => "Registro no encontrado"]);
    exit;
}
$stmt->close();

// Actualizamos likes o corazones
if ($tipo === "like") {
    $stmt = $conn->prepare("UPDATE media SET likes = likes + 1 WHERE id = ?");
} elseif ($tipo === "corazon") {
    $stmt = $conn->prepare("UPDATE media SET corazones = corazones + 1 WHERE id = ?");
} else {
    echo json_encode(["error" => "Tipo inválido"]);
    exit;
}

$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

// Obtenemos valores actualizados
$stmt = $conn->prepare("SELECT likes, corazones FROM media WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();
$stmt->close();

echo json_encode($res);
