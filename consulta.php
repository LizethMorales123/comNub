<?php
// consultar.php

// Usaremos la conexión a BD PaaS (Azure Database)
require 'config-paas.php'; // Este archivo ahora retorna $conn como un objeto PDO

echo "Conexión exitosa a la base de datos SQL Server!<br>";

try {
    // Consulta SQL: Ahora también incluimos 'id' y 'fecha_registro' para mostrarlos.
    // Asegúrate de que las columnas 'id', 'matricula', 'nombre', 'carrera', 'fecha_registro'
    // coincidan exactamente con los nombres en tu tabla 'alumnos'.
    $sql = "SELECT id, matricula, nombre, carrera, fecha_registro FROM alumnos ORDER BY id DESC";

    // Para consultas SELECT simples sin parámetros, PDO::query() es adecuado.
    $stmt = $conn->query($sql);

    echo "<h1>Registros de Alumnos</h1>";

    // Comprueba si se encontraron registros usando rowCount() de PDOStatement
    if ($stmt->rowCount() > 0) {
        echo "<table border='1'>
        <tr>
        <th>ID</th>
        <th>Matrícula</th>
        <th>Nombre</th>
        <th>Carrera</th>
        <th>Fecha Registro</th>
        </tr>";

        // Recorrer los resultados usando fetch(PDO::FETCH_ASSOC)
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['matricula']) . "</td>";
            echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
            echo "<td>" . htmlspecialchars($row['carrera']) . "</td>";
            echo "<td>" . htmlspecialchars($row['fecha_registro']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron registros de alumnos.";
    }

} catch (PDOException $e) {
    // Captura cualquier excepción de PDO (errores de SQL, etc.)
    echo "Error al consultar los registros: " . $e->getMessage();
}

// Con PDO, no es necesario llamar a $conn->close(). La conexión se cierra automáticamente
// cuando el script termina o el objeto $conn es destruido.
?>
