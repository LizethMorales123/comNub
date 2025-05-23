<?php

// Es MUY RECOMENDABLE NO HARDCODEAR CREDENCIALES
// En un entorno de producción, usa variables de entorno para Uid y PWD.
// Por ejemplo:
// $serverName = getenv('DB_SERVER_NAME');
// $databaseName = getenv('DB_DATABASE_NAME');
// $uid = getenv('DB_USERNAME');
// $pwd = getenv('DB_PASSWORD');

$serverName = "20.10.2.4";
$connectionOptions = array(
    "Database" => "bd_u5",
    "Uid" => "adminlizeth",
    "PWD" => "pass123$" // ¡Recuerda, esto debe ir en variables de entorno en producción!
);

try {
    // Establecer la conexión con PDO_SQLSRV
    $conn = new PDO("sqlsrv:Server=$serverName;Database=" . $connectionOptions['Database'], $connectionOptions['Uid'], $connectionOptions['PWD']);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Habilita el modo de error de excepciones para un mejor manejo de errores

    echo "Conexión exitosa a la base de datos SQL Server!";

} catch (PDOException $e) {
    $errorMessage = "Conexión fallida a SQL Server: " . $e->getMessage();

    // Registra el error en los logs de la aplicación de Azure App Service
    error_log($errorMessage);

    // Muestra un mensaje amigable al usuario en la página web
    die("Lo sentimos, no pudimos conectar con la base de datos. Por favor, inténtelo de nuevo más tarde o contacte al soporte.");
}
?>
