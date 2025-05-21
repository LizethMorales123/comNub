<?php
// guardar.php

// Usaremos la conexión a BD PaaS (Azure Database)
require 'config-paas.php';

// Verificar que los datos del formulario POST existan
if (!isset($_POST['matricula']) || !isset($_POST['nombre']) || !isset($_POST['carrera'])) {
    die("Error: Faltan datos en el formulario.");
}

$matricula = $_POST['matricula'];
$nombre = $_POST['nombre'];
$carrera = $_POST['carrera'];

// --- IMPORTANTE: Usar Prepared Statements para prevenir Inyección SQL ---
// 1. Preparar la sentencia SQL
//    Nota: La tabla es 'alumnos', no 'estudiantes'. El campo 'id' es auto-incrementable y 'fecha_registro' tiene un DEFAULT,
//    así que no los incluimos en el INSERT.
$sql = "INSERT INTO alumnos (matricula, nombre, carrera) VALUES (?, ?, ?)";

// 2. Crear un objeto de sentencia preparada
if ($stmt = $conn->prepare($sql)) {
    // 3. Vincular los parámetros
    //    'sss' indica que los tres parámetros son de tipo string (s)
    $stmt->bind_param("sss", $matricula, $nombre, $carrera);

    // 4. Ejecutar la sentencia
    if ($stmt->execute()) {
        echo "Registro guardado en: " . (isset($is_paas) ? "PaaS" : "IaaS");
    } else {
        echo "Error al ejecutar la consulta: " . $stmt->error;
    }

    // 5. Cerrar la sentencia
    $stmt->close();
} else {
    echo "Error al preparar la consulta: " . $conn->error;
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
