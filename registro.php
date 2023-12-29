<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar si se recibieron los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del JSON enviado
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['username']) && isset($data['password'])) {
        // Obtener los datos del formulario
        $usuario = $data['username'];
        $contrasena = $data['password'];
        // Validar los datos
        // Conectar a la base de datos
        $conexion = mysqli_connect("localhost", "root", "", "usuarios");
        // Verificar si la conexión fue exitosa
        if (!$conexion) {
            http_response_code(500);
            echo json_encode(["error" => "Error al conectar a la base de datos: " . mysqli_connect_error()]);
            exit;
        }
        // Insertar los datos en la base de datos
        $consulta = "INSERT INTO usuarios (usuario, contrasena) VALUES ('$usuario', '$contrasena')";
        if (mysqli_query($conexion, $consulta)) {
            // Devolver una respuesta exitosa
            http_response_code(200);
            echo json_encode(["message" => "Usuario registrado exitosamente"]);
            exit;
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al registrar el usuario: " . mysqli_error($conexion)]);
            exit;
        }
        // Cerrar la conexión a la base de datos
        mysqli_close($conexion);
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Faltan datos de usuario o contraseña"]);
        exit;
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Método no permitido"]);
    exit;
}
?>