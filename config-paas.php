<?php
$server = "sqlserver-proyecto.database.windows.net"; 
$user = "app_estudiantes_u5";
$password = "PasswordSeguro789!"; 
$database = "bd_u5";
$is_paas = true; 

$conn = new mysqli($server, $user, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

echo "Conexión exitosa a la base de datos!";

?>
