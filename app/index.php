<?php
// Iniciar la sesión solo si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Aquí va el resto de tu código para la página
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to GraphMaster</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #121212; /* Fondo oscuro */
            color: #ffffff; /* Texto blanco */
        }

        .login-container {
            background-color: #1e1e1e; /* Contenedor oscuro */
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.4);
            overflow: hidden;
            width: 800px; /* Aumento del ancho */
            max-width: 100%;
        }

        .login-left {
            background-color: #343a40;
            color: white;
            padding: 40px; /* Aumentar padding */
            text-align: center;
        }

        .login-left img {
            width: 200px; /* Aumento del tamaño del logo */
        }

        .login-right {
            padding: 40px; /* Aumentar padding */
        }

        .form-control {
            border-radius: 20px;
            background-color: #2c2c2c; /* Fondo de los campos de entrada */
            color: #ffffff; /* Texto blanco */
            border: 1px solid #444; /* Borde oscuro */
            font-size: 1.2rem; /* Aumentar tamaño de fuente */
            padding: 15px; /* Aumentar padding en los campos de entrada */
        }

        .form-control:focus {
            border-color: #007bff; /* Color de borde al enfocar */
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.5); /* Sombra de enfoque */
        }

        .btn-primary {
            border-radius: 20px;
            background-color: #007bff; /* Color del botón */
            transition: background-color 0.3s, transform 0.3s;
            font-size: 1.2rem; /* Aumentar tamaño de fuente en botón */
            padding: 15px; /* Aumentar padding en el botón */
        }

        .btn-primary:hover {
            background-color: #0056b3; /* Color del botón al pasar el ratón */
            transform: translateY(-2px); /* Efecto de elevación */
        }

        .text-primary {
            font-weight: bold;
            font-size: 1.1rem; /* Aumentar tamaño de texto */
        }

        .text-muted {
            color: #bbb; /* Color gris para texto secundario */
            font-size: 1rem;
        }

        .fade-in {
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        /* Ajustes responsivos */
        @media (max-width: 768px) {
            .login-container {
                width: 100%;
            }

            .login-left, .login-right {
                padding: 20px;
            }

            .form-control, .btn-primary {
                font-size: 1rem;
            }

            .login-left img {
                width: 150px;
            }
        }
    </style>
</head>
<body>
<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-danger text-center">
        <?php echo $_SESSION['message']; ?>
    </div>
    <?php unset($_SESSION['message']); // Elimina el mensaje después de mostrarlo ?>
<?php endif; ?>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="login-container row fade-in">
            <div class="col-md-6 login-left">
                <div class="text-center">
                    <img src="public/img/IAgrap_logo.png" alt="GraphMaster Logo" class="img-fluid">
                    <h2 class="mt-3">IAgrap</h2>
                    <p class="text-muted">Herramienta IAgrap</p>
                </div>
            </div>
            <div class="col-md-6 login-right">
                <h4 class="text-center">Inicia en IAgrap</h4>
                <form action="../models/users/login.php" method="POST">


                    <div class="form-group">
                        <label for="username">Nombre</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">LOGIN</button>
                </form>
                <div class="text-center mt-3">
                    <p>No tienes cuenta? <a href="/pages/registro.php" class="text-primary">Regístrate aquí</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animaciones GSAP
        gsap.to(".fade-in", { 
            duration: 1, 
            opacity: 1, 
            ease: "power2.out" 
        });
        
        gsap.from(".login-left", { 
            duration: 1, 
            x: -50, 
            opacity: 0, 
            delay: 0.5 
        });

        gsap.from(".login-right", { 
            duration: 1, 
            x: 50, 
            opacity: 0, 
            delay: 0.5 
        });
        
        gsap.from(".form-group", { 
            duration: 0.5, 
            y: 20, 
            opacity: 0, 
            stagger: 0.1,
            delay: 1 
        });

        gsap.from("button", { 
            duration: 0.5, 
            y: 20, 
            opacity: 0, 
            stagger: 0.1,
            delay: 1.5 
        });
    </script>
</body>
</html>
