<?php
$host = "localhost";
$user = "vanguard_admin_hotel";
$pass = "Hotel.hackers.";
$dbname = "vanguard_Hotel";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
