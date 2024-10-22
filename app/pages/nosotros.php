<?php include '../shared/header.php'; ?>

<?php
// Verifica si el usuario está logueado
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // Redirige al usuario si no está autenticado
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
    <title>Acerca de Nosotros</title>
    <style>
        .hero {
            background-color: #f8f9fa;
            padding: 60px 0;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 0;
        }
        .section {
            padding: 40px 0;
        }
        .section h2 {
            margin-bottom: 20px;
            opacity: 0; /* Inicialmente oculto */
            transform: translateY(20px); /* Desplazado hacia abajo */
            transition: opacity 0.6s, transform 0.6s; /* Transiciones */
        }
        .section p {
            font-size: 1.1rem;
            line-height: 1.6;
        }
        .icon {
            font-size: 50px;
            color: #007bff;
            margin-bottom: 10px;
            transition: transform 0.3s; /* Transición para movimiento */
        }
        .icon:hover {
            transform: translateY(-5px) rotate(10deg); /* Efecto al pasar el mouse */
        }
        .menu-box {
            transition: transform 0.2s;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            background: #ffffff;
        }
        .menu-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>
    <div class="container hero">
        <h1>Bienvenido a GraphMaster</h1>
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
    <script>
        // Función para animar los títulos al hacer scroll
        document.addEventListener("DOMContentLoaded", function() {
            const sections = document.querySelectorAll('.section h2');
            const options = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = 1;
                        entry.target.style.transform = 'translateY(0)';
                        observer.unobserve(entry.target); // Dejar de observar una vez que se activa
                    }
                });
            }, options);

            sections.forEach(section => {
                observer.observe(section); // Iniciar la observación de cada título
            });
        });
    </script>
</body>
</html>
