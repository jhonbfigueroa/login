<?php
// Verificar si se recibieron los datos del formulario
if(isset($_POST['username']) && isset($_POST['password'])) {
    // Obtener los datos del formulario
    $usuario = $_POST['username'];
    $contrasena = $_POST['password'];

    // Validar los datos (puedes agregar tus propias validaciones aquí)

    // Conectar a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "usuarios");

    // Verificar si la conexión fue exitosa
    if (!$conexion) {
        die("Error al conectar a la base de datos: " . mysqli_connect_error());
    }

    // Insertar los datos en la base de datos
    $consulta = "INSERT INTO usuarios (usuario, contrasena) VALUES ('$usuario', '$contrasena')";
    if (mysqli_query($conexion, $consulta)) {
        // Redirigir al usuario a la página de inicio de sesión
        header("Location: inicio.html");
        exit();
    } else {
        echo "Error al registrar el usuario: " . mysqli_error($conexion);
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conexion);
}
?>