<?php
// guardar.php

// Usaremos la conexión a BD PaaS (Azure Database)
require 'config-paas.php'; // Este archivo ahora retorna $conn como un objeto PDO

// Verificar que los datos del formulario POST existan
if (!isset($_POST['matricula']) || !isset($_POST['nombre']) || !isset($_POST['carrera'])) {
    die("Error: Faltan datos en el formulario. Asegúrate de enviar matricula, nombre y carrera.");
}

$matricula = trim($_POST['matricula']); // Limpiar espacios al inicio/final
$nombre = trim($_POST['nombre']);
$carrera = trim($_POST['carrera']);

// Valida que los campos no estén completamente vacíos después de trim
if (empty($matricula) || empty($nombre) || empty($carrera)) {
    die("Error: Todos los campos (Matrícula, Nombre, Carrera) son obligatorios y no pueden estar vacíos.");
}

try {
    // --- IMPORTANTE: Usar Prepared Statements para prevenir Inyección SQL ---
    // 1. Preparar la sentencia SQL con PDO
    //    Tu tabla alumnos tiene id (IDENTITY) y fecha_registro (DEFAULT SYSDATETIME()),
    //    por lo tanto, solo insertamos matricula, nombre, y carrera.
    $sql = "INSERT INTO alumnos (matricula, nombre, carrera) VALUES (:matricula, :nombre, :carrera)";

    // 2. Crear un objeto de sentencia preparada (PDOStatement)
    $stmt = $conn->prepare($sql);

    // 3. Vincular los parámetros con PDO
    //    bindParam es el método de PDO. PDO::PARAM_STR se usa para datos de tipo cadena.
    $stmt->bindParam(':matricula', $matricula, PDO::PARAM_STR);
    $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $stmt->bindParam(':carrera', $carrera, PDO::PARAM_STR);

    // 4. Ejecutar la sentencia
    $stmt->execute();

    echo "Conexión exitosa a la base de datos SQL Server! Registro guardado exitosamente.";

    // Opcional: Redirigir al usuario después de un guardado exitoso
    // header("Location: consultar.php");
    // exit();

} catch (PDOException $e) {
    // Captura cualquier excepción de PDO (errores de SQL, etc.)
    echo "Error al guardar el registro: " . $e->getMessage();
}

// Con PDO, no es necesario llamar a $conn->close() ni a $stmt->close().
// Las conexiones se cierran automáticamente cuando el script termina o el objeto $conn es destruido.
?>
