<?php
session_start();
require 'database/conexion.php'; // Asegúrate de que este archivo contiene la conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Consulta para verificar el usuario
    $sql = "SELECT id, password, tipo FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verificar la contraseña
        if ($user && password_verify($password, $user['password'])) {
            // Establecer variables de sesión
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['tipo'] = $user['tipo'];

            // Redirigir al panel
            header("Location: panel.php");
            exit();
        } else {
            // Contraseña incorrecta
            header("Location: login.html");
            exit();
        }
    } else {
        // Usuario no encontrado
        header("Location: login.html");
        exit();
    }
} else {
    // Si no es una solicitud POST, redirigir al formulario de inicio de sesión
    header("Location: login.html");
    exit();
}
?>