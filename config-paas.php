<?php
$server = "20.10.1.4"; // IP privada de Azure Database
$user = "azureuser";
$password = "AzurePassword123!";
$database = "appdb";
$is_paas = true;

$conn = new mysqli($server, $user, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
