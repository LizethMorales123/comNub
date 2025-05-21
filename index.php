<?php
// index.php

// --- INICIO: Lógica de Conexión a BD (config-paas.php) ---
// Normalmente este código estaría en un archivo separado como config-paas.php
$server = "sqlserver-proyecto.database.windows.net"; // Tu FQDN de Azure SQL
$user = "app_estudiantes_u5"; // Tu usuario
$password = "PasswordSeguro789!"; // Tu contraseña
$database = "bd_u5"; // Tu base de datos

$conn = new mysqli($server, $user, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida a Azure SQL Database: " . $conn->connect_error);
}
// --- FIN: Lógica de Conexión a BD ---


// --- Lógica para Guardar Información (anteriormente en guardar.php) ---
// Solo procesa el POST si el formulario se envió
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar que los datos del formulario POST existan
    if (isset($_POST['matricula']) && isset($_POST['nombre']) && isset($_POST['carrera'])) {
        $matricula = $_POST['matricula'];
        $nombre = $_POST['nombre'];
        $carrera = $_POST['carrera'];

        $sql = "INSERT INTO alumnos (matricula, nombre, carrera) VALUES (?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sss", $matricula, $nombre, $carrera);

            if ($stmt->execute()) {
                echo "<p>Registro guardado exitosamente.</p>";
            } else {
                echo "<p>Error al ejecutar la consulta para guardar: " . $stmt->error . "</p>";
            }
            $stmt->close();
        } else {
            echo "<p>Error al preparar la consulta para guardar: " . $conn->error . "</p>";
        }
    } else {
        echo "<p>Error: Faltan datos al intentar guardar el registro.</p>";
    }
}
// --- FIN: Lógica para Guardar Información ---

?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro de Estudiantes - Cloud</title>
</head>
<body>
    <h1>Registro de Estudiantes</h1>
    <form action="index.php" method="post">
        <label>Matrícula:</label>
        <input type="text" name="matricula" required><br>

        <label>Nombre:</label>
        <input type="text" name="nombre" required><br>

        <label>Carrera:</label>
        <select name="carrera">
            <option value="Computacion">Computación</option>
            <option value="Cloud">Cómputo en la Nube</option>
        </select><br>

        <input type="submit" value="Guardar">
    </form>

    <hr> <h2>Registros Almacenados</h2>
    <?php
    // --- Lógica para Consultar Información (anteriormente en consulta.php) ---
    $sql = "SELECT matricula, nombre, carrera, fecha_registro FROM alumnos";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1'>
        <tr>
        <th>Matrícula</th>
        <th>Nombre</th>
        <th>Carrera</th>
        <th>Fecha Registro</th>
        </tr>";

        while($row = $result->fetch_assoc()) {
            echo "<tr>";
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
    // --- FIN: Lógica para Consultar Información ---

    // Cerrar la conexión al final del script
    $conn->close();
    ?>
</body>
</html>
