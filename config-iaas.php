<?php
$server = "10.10.1.4"; // IP de la VM Linux
$user = "appuser";
$password = "Password123";
$database = "appdb";

$conn = new mysqli($server, $user, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
