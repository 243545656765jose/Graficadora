<?php include '../shared/header.php'; ?>

<?php
// Verifica si el usuario está logueado
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // Redirige al usuario si no está autenticado
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GraphMaster - Main Menu</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/public/css/menu.css">
</head>
<body>

<div class="container menu-container">
    <div class="row justify-content-center">
        <!-- Insertar Datos Button -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="menu-box">
                <i class="fas fa-edit menu-icon"></i>
                <h3 class="menu-title">Insertar Datos</h3>
                <a href="insertar_datos.php" class="btn btn-custom mt-3">Ingresar</a>
            </div>
        </div>
        <!-- Cargar Datos Button -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="menu-box">
                <i class="fas fa-upload menu-icon"></i>
                <h3 class="menu-title">Cargar Datos</h3>
                <a href="importdata.php" class="btn btn-custom mt-3">Cargar</a>
            </div>
        </div>
        <!-- Actualizar Información Button -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="menu-box">
                <i class="fas fa-user-edit menu-icon"></i>
                <h3 class="menu-title">Actualizar Información</h3>
                <a href="editar_info.php" class="btn btn-custom mt-3">Actualizar</a>
            </div>
        </div>
        <!-- Tablas Compartidas Button -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="menu-box">
                <i class="fas fa-table menu-icon"></i>
                <h3 class="menu-title">Tablas Compartidas</h3>
                <a href="compartir.php" class="btn btn-custom mt-3">Ver Tablas</a>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="menu-box">
                <i class="fas fa-table menu-icon"></i>
                <h3 class="menu-title">Datos desagrupados</h3>
                <a href="desagrupar1.php" class="btn btn-custom mt-3">Insetar datos</a>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
