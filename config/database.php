<?php
// Configuración de la base de datos
$host = 'localhost'; // Cambia esto por tu host si no es localhost
$port = '5432';      // El puerto por defecto de PostgreSQL
$dbname = 'task_manager'; // Reemplaza con el nombre de tu base de datos
$user = 'root1'; // Reemplaza con tu nombre de usuario
$password = 'admin123'; // Reemplaza con tu contraseña

// Crear una cadena de conexión
$connection_string = "host=$host port=$port dbname=$dbname user=$user password=$password";

// Intentar conectar a la base de datos
$dbconn = pg_connect($connection_string);

// Verificar la conexión
if ($dbconn) {
    echo "Conexión exitosa a la base de datos PostgreSQL!";
} else {
    echo "Error al conectar a la base de datos PostgreSQL.";
}


?>
