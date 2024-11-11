<?php
// Iniciar la sesión solo si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to GraphMaster</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="/public/css/login.css">
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
