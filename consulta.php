<?php
require 'config-paas.php'; // o config-paas.php

$sql = "SELECT * FROM estudiantes";
$result = $conn->query($sql);

echo "<h1>Registros almacenados</h1>";
echo "<table border='1'>
<tr>
<th>Matrícula</th>
<th>Nombre</th>
<th>Carrera</th>
</tr>";

while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['matricula'] . "</td>";
    echo "<td>" . $row['nombre'] . "</td>";
    echo "<td>" . $row['carrera'] . "</td>";
    echo "</tr>";
}
echo "</table>";

$conn->close();
?>
