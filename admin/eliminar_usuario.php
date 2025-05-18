<?php
// Conexión a la base de datos (reemplaza con tus credenciales)
$con = mysqli_connect("sql311.infinityfree.com", "if0_38880937", "QCMAvlp9f0", "if0_38880937_tickets");

// Verificar la conexión
if (mysqli_connect_errno()) {
    echo "Error al conectar a MySQL: " . mysqli_connect_error();
    exit();
}

// Obtener el ID del usuario de la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_usuario = $_GET['id'];

    // Consulta SQL para eliminar el usuario
    $query = "DELETE FROM user WHERE id = $id_usuario";

    if (mysqli_query($con, $query)) {
        // La eliminación fue exitosa
        header("Location: manage-users.php?mensaje=usuario_eliminado"); // Redirigir
        exit();
    } else {
        // Error al eliminar el usuario
        header("Location: manage-users.php?mensaje=error_al_eliminar"); // Redirigir con error
        exit();
    }
} else {
    // ID no válido
    header("Location: manage-users.php?mensaje=id_invalido"); // Redirigir con error
    exit();
}

mysqli_close($con);
?>