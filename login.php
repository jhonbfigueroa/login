<?php
// Obtener los valores enviados desde el formulario
$username = $_POST['username'];
$password = $_POST['password'];

// Conectar a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "usuarios");

// Verificar si la conexión fue exitosa
if (!$conexion) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

// Preparar la consulta SQL
$consulta = "SELECT * FROM usuarios WHERE usuario = ?";

// Preparar la declaración
$stmt = mysqli_prepare($conexion, $consulta);

// Vincular los parámetros
mysqli_stmt_bind_param($stmt, "s", $username);

// Ejecutar la consulta
mysqli_stmt_execute($stmt);

// Obtener los resultados
$resultado = mysqli_stmt_get_result($stmt);

// Verificar si se encontró un usuario
if (mysqli_num_rows($resultado) > 0) {
    // Obtener los datos del usuario
    $usuario = mysqli_fetch_assoc($resultado);

    // Verificar la contraseña
    if ($password == $usuario['contrasena']) {
        // La autenticación es correcta, redirigir al usuario a una página de inicio de sesión exitoso
        header("Location: inicio.html");
        exit;
    }
}

// Si la autenticación es incorrecta, mostrar un mensaje de error
echo "Error en la autenticación";

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>