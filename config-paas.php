<?php
$serverName = "20.10.2.4"; // ¡Cámbialo a esto!
$connectionOptions = array(
    "Database" => "bd_u5",
    "Uid" => "app_estudiantes_u5",
    "PWD" => "PasswordSeguro789!" // ¡Recuerda, esto debe ir en variables de entorno en producción!
);

try {
    // Establecer la conexión con PDO_SQLSRV
    $conn = new PDO("sqlsrv:Server=$serverName;Database=" . $connectionOptions['Database'], $connectionOptions['Uid'], $connectionOptions['PWD']);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conexión exitosa a la base de datos SQL Server!";

} catch (PDOException $e) {
    $errorMessage = "Conexión fallida a SQL Server: " . $e->getMessage();
    // Asegúrate de que el registro de aplicación esté habilitado en Azure para ver esto
    error_log($errorMessage); 
    die("Lo sentimos, no pudimos conectar con la base de datos. Por favor, inténtelo de nuevo más tarde o contacte al soporte.");
}
?>
