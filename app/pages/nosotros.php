<?php include '../shared/header.php'; ?>

<?php
// Verifica si el usuario está logueado
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/public/css/nosotros.css">
    <title>Acerca de Nosotros</title>
</head>

<body>
    <div class="container hero">
        <h1>Bienvenido a IAGraph</h1>
        <p>La herramienta que facilita el análisis de datos mediante gráficos intuitivos.</p>
    </div>

    <div class="container section">
        <h2><i class="fas fa-users icon animate__animated animate__bounceInDown"></i> ¿Quiénes Somos?</h2>
        <p>
            En GraphMaster, somos un equipo apasionado de desarrolladores y analistas de datos. Nuestra misión es proporcionar herramientas que hagan que el análisis de datos sea accesible y comprensible para todos.
        </p>
    </div>

    <div class="container section">
        <h2><i class="fas fa-eye icon animate__animated animate__bounceInDown"></i> Nuestra Visión</h2>
        <p>
            Creemos que el análisis de datos no debería ser complicado. Con nuestra plataforma, pretendemos simplificar la visualización de datos, permitiendo a los usuarios tomar decisiones informadas de manera rápida y eficiente.
        </p>
    </div>

    <div class="container section">
        <h2><i class="fas fa-chart-line icon animate__animated animate__bounceInDown"></i> ¿Qué Hacemos?</h2>
        <p>
            GraphMaster te permite cargar tus datos y generar gráficos de manera sencilla. Ya sea que necesites analizar tendencias, comparar datos o presentar resultados, nuestra herramienta está diseñada para ayudarte en cada paso del camino. 
        </p>
        <p>
            Nuestros gráficos son personalizables y fáciles de entender, lo que te permite centrarte en lo que realmente importa: tus datos.
        </p>
    </div>

    <div class="container section text-center">
        <h2><i class="fas fa-thumbs-up icon animate__animated animate__bounceInDown"></i> ¡Únete a Nosotros!</h2>
        <p>
            Ya sea que seas un estudiante, un profesional o simplemente alguien interesado en los datos, ¡GraphMaster es para ti! Comienza a explorar tus datos de una manera visualmente atractiva y útil.
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/js/nosotros.js"></script>
</body>
</html>
