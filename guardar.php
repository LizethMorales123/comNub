<?php
// Conexión a BD IaaS (VM Linux)
require 'config-iaas.php'; 

// O conexión a BD PaaS (Azure Database)
// require 'config-paas.php';

$matricula = $_POST['matricula'];
$nombre = $_POST['nombre'];
$carrera = $_POST['carrera'];

$sql = "INSERT INTO estudiantes (matricula, nombre, carrera) VALUES ('$matricula', '$nombre', '$carrera')";

if ($conn->query($sql) {
    echo "Registro guardado en: " . (isset($is_paas) ? "PaaS" : "IaaS";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
