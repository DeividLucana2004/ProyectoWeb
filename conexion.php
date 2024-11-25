<?php
// Configuración de la base de datos
$servidor = "DESKTOP-0O029LO\MSSQLSERVER01"; // Nombre del servidor de SQL Server
$usuario = "";  // El nombre de usuario de SQL Server
$contrasena = "";  // La contraseña de SQL Server
$base_de_datos = "pagina_web";  // Nombre de la base de datos

// Conectar a SQL Server usando la extensión sqlsrv
$conexion = sqlsrv_connect($servidor, array(
    "Database" => $base_de_datos,
    "UID" => $usuario,
    "PWD" => $contrasena
));

// Verificar si la conexión es exitosa
if ($conexion === false) {
    die("Error de conexión: " . print_r(sqlsrv_errors(), true));
}

// Obtener los datos del formulario
$nombre_usuario = $_POST['nombre_usuario'];
$contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
$nombre_completo = $_POST['nombre_completo'];
$correo = $_POST['correo'];

// Preparar la consulta SQL con parámetros
$query = "INSERT INTO usuarios (nombre_usuario, contrasena, nombre_completo, correo)
          VALUES (?, ?, ?, ?)";

// Preparar la consulta
$stmt = sqlsrv_prepare($conexion, $query, array(&$nombre_usuario, &$contrasena, &$nombre_completo, &$correo));

// Ejecutar la consulta
if (sqlsrv_execute($stmt)) {
    echo "Registro exitoso. ¡Bienvenido, $nombre_usuario!";
} else {
    echo "Error: " . print_r(sqlsrv_errors(), true);
}

// Cerrar la conexión
sqlsrv_free_stmt($stmt);
sqlsrv_close($conexion);
?>