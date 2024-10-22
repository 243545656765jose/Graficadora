<?php
// Inicia la sesión para obtener el nombre del usuario logueado
session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : 'Invitado'; // Cambia esto a tu lógica de autenticación
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Gestor de Datos</title>
    <style>
        

        /* Barra de navegación personalizada */
        .navbar {
            background-color: #343a40; /* Color de fondo oscuro */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .navbar-brand img {
            height: 40px;
        }

        .nav-link {
            color: rgba(255, 206, 86, 1); /* Amarillo suave */
            margin-right: 15px;
            transition: color 0.3s;
        }

        .nav-link:hover {
            color: rgba(153, 102, 255, 1); /* Púrpura suave */
            text-decoration: underline; /* Subrayar al pasar el mouse */
        }

        .user-info {
            color: rgba(75, 192, 192, 1); /* Verde suave */
            margin-right: 15px;
            font-weight: bold;
        }

        .btn-outline-light {
            color: rgba(54, 162, 235, 1); /* Azul suave */
            border-color: rgba(54, 162, 235, 1);
            transition: background-color 0.3s;
        }

        .btn-outline-light:hover {
            background-color: rgba(54, 162, 235, 0.2); /* Fondo azul suave al pasar el ratón */
        }

        /* Mejoras para dispositivos móviles */
        @media (max-width: 768px) {
            .navbar-nav {
                margin-top: 10px;
            }

            .user-info {
                margin-top: 10px;
            }
        }
    </style>
</head>

<body>
    <!-- Barra de Navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand" href="index.php">
                <img src="/public/img/IAgrap_logo.png" alt="Logo"> <!-- Cambia el src al path de tu logo -->
                Mi Aplicación
            </a>

            <!-- Botón para menú responsivo -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menú de Navegación -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="menu.php"><i class="fas fa-home"></i> Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="nosotros.php"><i class="fas fa-info-circle"></i> Acerca de</a>
                    </li>
                   
                    
                </ul>

                <!-- Información del Usuario -->
                <div class="d-flex align-items-center">
                    <span class="user-info">
                        <i class="fas fa-user"></i> <?php echo $user; ?>
                    </span>
                    <!-- Enlace para cerrar sesión, si el usuario está logueado -->
                    <?php if ($user !== 'Invitado'): ?>
                        <a href="../models/users/cerrarsesion.php" class="btn btn-outline-light"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-outline-light"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script>
        // Animación de entrada para la barra de navegación
        gsap.from(".navbar", { 
            duration: 1, 
            y: -50, 
            opacity: 0, 
            ease: "power2.out" 
        });
    </script>
</body>

</html>
