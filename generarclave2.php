<?php
require_once 'database/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $usuario_id = $_GET['id'] ?? null;

    if (!isset($usuario_id)) {
        die("ID de usuario no proporcionado");
    }

    // Generar contraseña aleatoria
    $nueva_clave = bin2hex(random_bytes(4)); // 8 caracteres hexadecimales
    $hash_clave = password_hash($nueva_clave, PASSWORD_DEFAULT);

    // Actualizar en base de datos
    $stmt = $conn->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("si", $hash_clave, $usuario_id);
        if ($stmt->execute()) {
            echo "Nueva contraseña para usuario ID $usuario_id: <strong>$nueva_clave</strong>";
        } else {
            echo "Error al actualizar la contraseña.";
        }
        $stmt->close();
    } else {
        echo "Error en la consulta.";
    }
    $conn->close();
}
?>