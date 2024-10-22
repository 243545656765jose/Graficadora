<?php
// Inicia la sesión
session_start();
$conn = include '../../utils/database.php'; // Asegúrate de tener un archivo para la conexión a la base de datos

// Verifica si el usuario está logueado
if (!isset($_SESSION['user'])) {
    header("Location: ../../login.php"); // Redirige al usuario si no está autenticado
    exit();
}

// Obtiene el nombre de usuario de la sesión
$current_username = $_SESSION['user'];

// Obtiene los datos del formulario
$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$current_password = $_POST['current_password'] ?? '';
$new_password = $_POST['new_password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Verifica que todos los campos estén llenos
if (empty($username) || empty($email) || empty($current_password) || empty($new_password) || empty($confirm_password)) {
    $_SESSION['message'] = "Por favor, llena todos los campos.";
    header("Location: ../../pages/editar_info.php"); // Redirige a la página de actualización
    exit();
}

// Verifica que la nueva contraseña y la confirmación sean iguales
if ($new_password !== $confirm_password) {
    $_SESSION['message'] = "La nueva contraseña y la confirmación no coinciden.";
    header("Location: ../../pages/editar_info.php"); // Redirige a la página de actualización
    exit();
}

// Consulta para obtener los datos del usuario actual
$query = "SELECT contrasena FROM usuarios WHERE nombre = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $current_username);
$stmt->execute();
$result = $stmt->get_result();

// Verifica si se encontró el usuario
if ($result->num_rows === 0) {
    $_SESSION['message'] = "Usuario no encontrado.";
    header("Location: ../../pages/editar_info.php"); // Redirige a la página de actualización
    exit();
}

$row = $result->fetch_assoc();
$hashed_password = $row['contrasena']; // Asegúrate de que el nombre de la columna sea correcto

// Verifica la contraseña actual
if (!password_verify($current_password, $hashed_password)) {
    $_SESSION['message'] = "La contraseña actual es incorrecta.";
    header("Location: ../../pages/editar_info.php"); // Redirige a la página de actualización
    exit();
}

// Si la contraseña es correcta, actualiza los datos
$new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
$update_query = "UPDATE usuarios SET nombre = ?, correo = ?, contrasena = ? WHERE nombre = ?";
$update_stmt = $conn->prepare($update_query);
$update_stmt->bind_param("ssss", $username, $email, $new_hashed_password, $current_username);

if ($update_stmt->execute()) {
    // Actualiza la sesión
    $_SESSION['user'] = $username; // Actualiza el nombre de usuario en la sesión
    $_SESSION['message'] = "Información actualizada con éxito.";
} else {
    $_SESSION['message'] = "Error al actualizar la información. Inténtalo de nuevo.";
}

// Cierra la conexión
$stmt->close();
$update_stmt->close();
$conn->close();

// Redirige a la página de menú después de la actualización
header("Location: ../../pages/menu.php"); // Corrige la ruta de redirección
exit();
?>
