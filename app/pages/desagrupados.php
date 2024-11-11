<?php include '../shared/header.php'; ?>
<?php


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirige si no está logueado
    exit();
}

// Función para truncar a dos decimales sin redondear
function truncarDosDecimales($valor) {
    return floor($valor * 100) / 100;
}

// Función para calcular la amplitud del intervalo
function calcularAmplitud($min, $max, $numClases) {
    $rango = $max - $min;
    return truncarDosDecimales($rango / $numClases); // Truncar a dos decimales
}

// Función para calcular la media
function calcularMedia($numeros) {
    return truncarDosDecimales(array_sum($numeros) / count($numeros));
}

// Función para calcular la moda
function calcularModa($numeros) {
    $valores = array_count_values($numeros);
    $maxFrecuencia = max($valores);
    $modas = array_keys($valores, $maxFrecuencia);
    return $modas;
}

// Función para calcular los intervalos
function calcularIntervalos($min, $amplitud, $numClases) {
    $intervalos = [];
    for ($i = 0; $i < $numClases; $i++) {
        $limInf = truncarDosDecimales($min + $i * $amplitud);
        $limSup = truncarDosDecimales($limInf + $amplitud);
        $intervalos[] = "$limInf - $limSup";
    }
    return $intervalos;
}

// Función para calcular los límites indicados
function calcularLimitesIndicados($intervalos, $max) {
    $limitesIndicados = [];
    foreach ($intervalos as $index => $intervalo) {
        list($limInf, $limSup) = explode(" - ", $intervalo);
        // Mantener el último límite superior igual al máximo
        $limSupReal = ($index === count($intervalos) - 1) ? $max : truncarDosDecimales($limSup - 1);
        $limitesIndicados[] = "$limInf - $limSupReal";
    }
    return $limitesIndicados;
}

// Función para calcular las frecuencias absolutas considerando todos los números en el rango
function calcularFrecuenciasAbsolutas($numeros, $limitesIndicados) {
    $frecuencias = array_fill(0, count($limitesIndicados), 0);

    // Iterar sobre los límites indicados para calcular las frecuencias
    foreach ($limitesIndicados as $index => $limite) {
        list($limInf, $limSup) = explode(" - ", $limite);
        
        // Contar cuántos números están en el rango definido por los límites
        foreach ($numeros as $numero) {
            // Verificar que el número esté dentro del intervalo
            if ($numero >= $limInf && $numero <= $limSup) {
                $frecuencias[$index]++; // Incrementar la frecuencia
            }
        }
    }

    return $frecuencias;
}

$resultado = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['numeros'], $_POST['clases'])) {
    $numeros = array_map('intval', explode(',', $_POST['numeros']));
    sort($numeros);
    $numClases = intval($_POST['clases']);
    $min = min($numeros);
    $max = max($numeros);

    // Cálculos adicionales
    $amplitud = calcularAmplitud($min, $max, $numClases);
    $media = calcularMedia($numeros);
    $modas = calcularModa($numeros);
    $intervalos = calcularIntervalos($min, $amplitud, $numClases);
    $limitesIndicados = calcularLimitesIndicados($intervalos, $max);
    $frecuenciasAbsolutas = calcularFrecuenciasAbsolutas($numeros, $limitesIndicados);
    
    $resultado = [
        'numeros' => $numeros,
        'min' => $min,
        'max' => $max,
        'amplitud' => $amplitud,
        'media' => $media,
        'modas' => $modas,
        'intervalos' => $intervalos,
        'limitesIndicados' => $limitesIndicados,
        'frecuenciasAbsolutas' => $frecuenciasAbsolutas,
    ];
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Distribución de Frecuencias</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
    <a href="../pages/menu.php" class="btn btn-danger mb-3" style="margin-top: 20px;">
            <i class="fas fa-arrow-left"></i> Atrás
        </a>
        <h2 class="text-center">Distribución de Frecuencias</h2>
        <form method="POST">
            <div class="form-group">
                <label for="numeros">Introduce números separados por comas:</label>
                <input type="text" class="form-control" id="numeros" name="numeros" required placeholder="Ejemplo: 5,3,8,10,2">
            </div>
            <div class="form-group">
                <label for="clases">Número de clases:</label>
                <input type="number" class="form-control" id="clases" name="clases" required min="1" placeholder="Ejemplo: 6">
            </div>
            <button type="submit" class="btn btn-primary">Calcular</button>
        </form>

        <?php if ($resultado): ?>
            <div class="mt-4 p-3 border rounded bg-light">
                <h3>Resultados Estadísticos</h3>
                <p><strong>Números Ingresados:</strong> <?php echo implode(', ', $resultado['numeros']); ?></p>
                <p><strong>Media Aritmética:</strong> <?php echo $resultado['media']; ?></p>
                <p><strong>Moda:</strong> <?php echo implode(', ', $resultado['modas']); ?></p>
                <p><strong>Mínimo:</strong> <?php echo $resultado['min']; ?></p>
                <p><strong>Máximo:</strong> <?php echo $resultado['max']; ?></p>
                <p><strong>Amplitud:</strong> <?php echo $resultado['amplitud']; ?></p>
                <p><strong>Intervalos:</strong> <?php echo implode(', ', $resultado['intervalos']); ?></p>
                <p><strong>Límites Indicados:</strong> <?php echo implode(', ', $resultado['limitesIndicados']); ?></p>
                <p><strong>Frecuencias Absolutas:</strong> <?php echo implode(', ', $resultado['frecuenciasAbsolutas']); ?></p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS, Popper.js, jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
