<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to GraphMaster</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="public/css/login.css">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="login-container row">
            <div class="col-md-6 login-left">
                <div class="text-center">
                    <img src="public/img/IAgrap_logo.png" alt="GraphMaster Logo" class="img-fluid" style="width: 150px;">
                    <h2 class="mt-3">IAgrap</h2>
                    <p class="text-muted">Herramienta IAgrap</p>
                </div>
            </div>
            <div class="col-md-6 login-right">
                <h4 class="text-center">Inicia en IAgrap</h4>
                <form action="actions/users/login.php" method="POST">
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
                        <label for="password">Contrasena</label>
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
                    <p>No tienes cuenta? <a href="pages/registerUser.php" class="text-primary">Registrese aqui</a></p>
                </div>
            </div>
        </div>
    </div>
    <?php include 'shared/footer.php'; ?>
</body>
</html>
