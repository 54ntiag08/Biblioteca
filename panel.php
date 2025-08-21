<?php
session_start();
require 'database/conexion.php';
//echo "entro!"; //exit;
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] != 'estudiante') {
    //header("Location: login.html");
    //exit();
}

// Obtener libros prestados
$sql = "SELECT libros.titulo, prestamos.fecha_prestamo, prestamos.fecha_devolucion FROM prestamos
        JOIN libros ON prestamos.libro_id = libros.id
        WHERE prestamos.usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['usuario_id']);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <title>Panel de Estudiante</title>
    <style>
        body {
            background-color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Libros Prestados</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Fecha de Préstamo</th>
                    <th>Fecha de Devolución</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['titulo']; ?></td>
                    <td><?php echo $row['fecha_prestamo']; ?></td>
                    <td><?php echo $row['fecha_devolucion']; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>