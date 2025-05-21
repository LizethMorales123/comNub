<?php
// consultar.php

// Usaremos la conexión a BD PaaS (Azure Database)
require 'config-paas.php';

// Verificar que la conexión fue exitosa
if ($conn->connect_error) {
    die("Error de conexión al cargar registros: " . $conn->connect_error);
}

// Consulta SQL
// Nota: La tabla es 'alumnos', no 'estudiantes'.
$sql = "SELECT matricula, nombre, carrera FROM alumnos";
$result = $conn->query($sql);

echo "<h1>Registros de Alumnos</h1>";

if ($result->num_rows > 0) {
    echo "<table border='1'>
    <tr>
    <th>Matrícula</th>
    <th>Nombre</th>
    <th>Carrera</th>
    <th>Fecha Registro</th>
    </tr>"; // Añadido 'Fecha Registro' para mostrar todas las columnas

    // Recorrer los resultados
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['matricula']) . "</td>"; // Usar htmlspecialchars para seguridad XSS
        echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
        echo "<td>" . htmlspecialchars($row['carrera']) . "</td>";
        echo "<td>" . htmlspecialchars($row['fecha_registro']) . "</td>"; // Mostrar fecha_registro
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron registros de alumnos.";
}

// Cerrar la conexión
$conn->close();
?>
