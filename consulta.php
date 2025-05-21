<?php
// consultar.php

// Usaremos la conexión a BD PaaS (Azure Database)
require 'config-paas.php'; // Este archivo ahora retorna $conn como un objeto PDO

echo "Conexión exitosa a la base de datos SQL Server!<br>";

try {
    // Consulta SQL: Asegúrate de que las columnas 'id', 'matricula', 'nombre', 'carrera', 'fecha_registro'
    // coincidan exactamente con los nombres en tu tabla 'alumnos' en SQL Server.
    $sql = "SELECT id, matricula, nombre, carrera, fecha_registro FROM alumnos ORDER BY id DESC";

    // Para consultas SELECT simples sin parámetros, PDO::query() es el método adecuado.
    $stmt = $conn->query($sql);

    echo "<h1>Registros de Alumnos</h1>";

    // **IMPORTANTE:** rowCount() en PDO para SELECTs no es confiable para SQL Server
    // y otros drivers. Puede devolver -1 o 0 incluso si hay filas.
    // La forma más robusta de saber si hay filas es intentar hacer un fetch.
    // Si no hay filas, fetch() devolverá false.

    // Intentar obtener la primera fila para ver si hay resultados
    $first_row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($first_row) { // Si se pudo obtener la primera fila, entonces hay datos
        echo "<table border='1'>
        <tr>
        <th>ID</th>
        <th>Matrícula</th>
        <th>Nombre</th>
        <th>Carrera</th>
        <th>Fecha Registro</th>
        </tr>";

        // Muestra la primera fila
        echo "<tr>";
        echo "<td>" . htmlspecialchars($first_row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($first_row['matricula']) . "</td>";
        echo "<td>" . htmlspecialchars($first_row['nombre']) . "</td>";
        echo "<td>" . htmlspecialchars($first_row['carrera']) . "</td>";
        echo "<td>" . htmlspecialchars($first_row['fecha_registro']) . "</td>";
        echo "</tr>";

        // Recorre el resto de los resultados (si los hay)
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
