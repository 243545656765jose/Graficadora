<?php include '../shared/header.php'; ?>
<?php
// Asegúrate de que la sesión del usuario esté activa
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirige si no está logueado
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Actualizar Información de Usuario</title>
    <style>
        body {
            background-color: #121212; /* Fondo oscuro */
            color: #ffffff; /* Texto blanco */
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="text-center mb-4">Actualizar Información de Usuario</h2>

    <!-- Botón Atrás -->
    <a href="../pages/menu.php" class="btn btn-secondary mb-3">
        <i class="fas fa-arrow-left"></i> Atrás
    </a>

    <!-- Mostrar Mensajes -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-info">
            <?php echo $_SESSION['message']; ?>
        </div>
        <?php unset($_SESSION['message']); // Elimina el mensaje después de mostrarlo ?>
    <?php endif; ?>

    <form action="/models/users/edit.php" method="POST">
        <!-- Campo oculto para el ID del usuario -->
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">

        <div class="form-group">
            <label for="username">Nuevo Nombre de Usuario</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="email">Nuevo Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="current_password">Contraseña Actual</label>
            <input type="password" class="form-control" id="current_password" name="current_password" required>
        </div>
        <div class="form-group">
            <label for="new_password">Nueva Contraseña</label>
            <input type="password" class="form-control" id="new_password" name="new_password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirmar Nueva Contraseña</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Actualizar</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
