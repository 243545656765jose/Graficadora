<?php include '../shared/header.php'; ?>

<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/css/editarinf.css"> <!-- Archivo CSS externo -->
    <title>Actualizar Contraseña</title>
</head>
<body>
<div class="container">
    <a href="../pages/menu.php" class="btn-back mb-3">
        <i class="fas fa-arrow-left"></i> Atrás
    </a>
    <h2 class="text-center">Actualizar Contraseña</h2>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-info">
            <?php echo $_SESSION['message']; ?>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <form action="/models/users/edit.php" method="POST">
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
        <button type="submit" class="btn btn-primary btn-block mt-4">Actualizar Contraseña</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="/public/js/editinfo.js"></script> <!-- Archivo JavaScript externo -->
</body>
</html>
