<?php
session_start();
$conn = include '../../utils/database.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../../index.php");
    exit();
}

$current_username = $_SESSION['user'];
$current_password = $_POST['current_password'] ?? '';
$new_password = $_POST['new_password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Verifica que todos los campos estén llenos
if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
    $_SESSION['message'] = "Por favor, llena todos los campos.";
    header("Location: ../../pages/editar_info.php");
    exit();
}

// Verifica que la nueva contraseña y la confirmación sean iguales
if ($new_password !== $confirm_password) {
    $_SESSION['message'] = "La nueva contraseña y la confirmación no coinciden.";
    header("Location: ../../pages/editar_info.php");
    exit();
}

// Consulta para obtener la contraseña actual del usuario
$query = "SELECT contrasena FROM usuarios WHERE nombre = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $current_username);
$stmt->execute();
$result = $stmt->get_result();

// Verifica si se encontró el usuario
if ($result->num_rows === 0) {
    $_SESSION['message'] = "Usuario no encontrado.";
    header("Location: ../../pages/editar_info.php");
    exit();
}

$row = $result->fetch_assoc();
$hashed_password = $row['contrasena'];

// Verifica la contraseña actual
if (!password_verify($current_password, $hashed_password)) {
    $_SESSION['message'] = "La contraseña actual es incorrecta.";
    header("Location: ../../pages/editar_info.php");
    exit();
}

// Si la contraseña actual es correcta, actualiza solo la contraseña
$new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
$update_query = "UPDATE usuarios SET contrasena = ? WHERE nombre = ?";
$update_stmt = $conn->prepare($update_query);
$update_stmt->bind_param("ss", $new_hashed_password, $current_username);

if ($update_stmt->execute()) {
    $_SESSION['message'] = "Contraseña actualizada con éxito.";
} else {
    $_SESSION['message'] = "Error al actualizar la contraseña. Inténtalo de nuevo.";
}

// Cierra las conexiones
$stmt->close();
$update_stmt->close();
$conn->close();

// Redirige a la página de menú después de la actualización
header("Location: ../../pages/menu.php");
exit();
?>
