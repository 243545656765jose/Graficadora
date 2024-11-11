<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register to GraphMaster</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/public/css/registro.css">
    
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="register-container row fade-in">
            <div class="col-md-6 register-left">
                <div class="text-center">
                    <img src="/public/img/IAgrap_logo.png" alt="GraphMaster Logo" class="img-fluid">
                    <h2 class="mt-3">IAgrap</h2>
                    <p class="text-muted">Crea una cuenta para comenzar a graficar</p>
                </div>
            </div>
            <div class="col-md-6 register-right">
                <h4 class="text-center">Regístrate en IAgrap</h4>
                <form action="/models/users/add.php" method="POST">
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
                        <label for="email">Email</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input type="email" class="form-control" id="email" name="email" required>
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
                    <button type="submit" class="btn btn-primary btn-block">REGISTER</button>
                </form>
                <div class="text-center mt-3">
                    <p>¿Ya tienes una cuenta? <a href="/index.php" class="text-primary">Inicia sesión aquí</a></p>
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

        gsap.from(".register-left", { 
            duration: 1, 
            x: -50, 
            opacity: 0, 
            delay: 0.5 
        });

        gsap.from(".register-right", { 
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
