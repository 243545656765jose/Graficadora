<?php include '../shared/header.php'; ?>
<?php
session_start();

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

// Función para calcular los límites indicados
function calcularLimitesIndicados($min, $amplitud, $numClases) {
    $limitesIndicados = [];
    for ($i = 0; $i < $numClases; $i++) {
        $limInf = truncarDosDecimales($min + $i * $amplitud);
        $limSup = truncarDosDecimales($limInf + $amplitud);
        $limitesIndicados[] = "$limInf - $limSup";
    }
    return $limitesIndicados;
}

// Función para calcular los límites reales
function calcularLimitesReales($limitesIndicados) {
    $limitesReales = [];
    foreach ($limitesIndicados as $limite) {
        list($limInf, $limSup) = explode(" - ", $limite);
        $limInfReal = truncarDosDecimales($limInf - 0.5);
        $limSupReal = truncarDosDecimales($limSup + 0.5);
        $limitesReales[] = "$limInfReal - $limSupReal";
    }
    return $limitesReales;
}

// Función para calcular los puntos medios
function calcularPuntosMedios($limitesReales) {
    $puntosMedios = [];
    foreach ($limitesReales as $limite) {
        list($limInfReal, $limSupReal) = explode(" - ", $limite);
        $puntosMedios[] = truncarDosDecimales(($limInfReal + $limSupReal) / 2);
    }
    return $puntosMedios;
}

// Función para calcular las frecuencias absolutas
function calcularFrecuencias($numeros, $limitesReales) {
    $frecuencias = array_fill(0, count($limitesReales), 0);
    
    foreach ($numeros as $numero) {
        foreach ($limitesReales as $index => $limite) {
            list($limInfReal, $limSupReal) = explode(" - ", $limite);
            if ($numero >= $limInfReal && $numero < $limSupReal) {
                $frecuencias[$index]++;
                break; // Salir del bucle una vez que se cuenta la frecuencia
            }
        }
    }

    return $frecuencias;
}

// Función para calcular frecuencias acumuladas "menos de"
function calcularFrecuenciasAcumuladasMenosDe($frecuencias) {
    $acumMenosDe = [];
    $suma = 0;
    foreach ($frecuencias as $frecuencia) {
        $suma += $frecuencia;
        $acumMenosDe[] = $suma;
    }
    return $acumMenosDe;
}

// Función para calcular frecuencias acumuladas "más de"
function calcularFrecuenciasAcumuladasMasDe($frecuencias) {
    $acumMasDe = [];
    $suma = array_sum($frecuencias);
    foreach ($frecuencias as $frecuencia) {
        $suma -= $frecuencia;
        $acumMasDe[] = $suma;
    }
    return $acumMasDe;
}

// Función para calcular frecuencias relativas
function calcularFrecuenciasRelativas($frecuencias, $totalDatos) {
    return array_map(function($f) use ($totalDatos) {
        return truncarDosDecimales(($f / $totalDatos) * 100);
    }, $frecuencias);
}

$resultado = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['numeros'], $_POST['clases'])) {
    $numeros = array_map('intval', explode(',', $_POST['numeros']));
    sort($numeros);
    $numClases = intval($_POST['clases']);
    $min = min($numeros);
    $max = max($numeros);

    // Cálculos de amplitud y otros valores
    $amplitud = calcularAmplitud($min, $max, $numClases);
    $limitesIndicados = calcularLimitesIndicados($min, $amplitud, $numClases); // Calcula los límites indicados
    $limitesReales = calcularLimitesReales($limitesIndicados);
    $puntosMedios = calcularPuntosMedios($limitesReales);
    $frecuencias = calcularFrecuencias($numeros, $limitesReales); // Calcular frecuencias
    $totalDatos = count($numeros);
    $frecuenciasRelativas = calcularFrecuenciasRelativas($frecuencias, $totalDatos); // Calcular frecuencias relativas
    $acumMenosDe = calcularFrecuenciasAcumuladasMenosDe($frecuencias); // Calcular acumuladas "menos de"
    $acumMasDe = calcularFrecuenciasAcumuladasMasDe($frecuencias); // Calcular acumuladas "más de"

    $resultado = [
        'numeros' => $numeros,
        'min' => $min,
        'max' => $max,
        'amplitud' => $amplitud,
        'limitesIndicados' => $limitesIndicados,
        'limitesReales' => $limitesReales,
        'puntosMedios' => $puntosMedios,
        'frecuencias' => $frecuencias,
        'frecuenciasRelativas' => $frecuenciasRelativas,
        'acumMenosDe' => $acumMenosDe,
        'acumMasDe' => $acumMasDe,
    ];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Distribución de Frecuencias</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        input[type="text"], input[type="number"] { width: 100%; padding: 10px; margin-bottom: 10px; }
        button { padding: 10px 20px; cursor: pointer; }
        .result, .table-container { margin-top: 20px; background-color: #f4f4f4; padding: 10px; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #ddd; text-align: center; }
        th { background-color: #add8e6; color: black; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Distribución de Frecuencias</h2>
        <form method="POST">
            <label for="numeros">Introduce números separados por comas:</label>
            <input type="text" id="numeros" name="numeros" required placeholder="Ejemplo: 5,3,8,10,2">
            <label for="clases">Número de clases:</label>
            <input type="number" id="clases" name="clases" required min="1" placeholder="Ejemplo: 6">
            <button type="submit">Calcular</button>
        </form>

        <?php if ($resultado): ?>
            <div class="table-container">
                <h3>Tabla de Distribución de Frecuencias</h3>
                <table>
                    <tr>
                        <th>Límites Indicados</th>
                        <th>Límites Reales</th>
                        <th>Puntos Medios Xi</th>
                        <th>Frecuencia Absoluta Fi</th>
                        <th>Frecuencia Relativa (%)</th>
                        <th>ACUM "menos de"</th>
                        <th>ACUM "más de"</th>
                    </tr>
                    <?php for ($i = 0; $i < count($resultado['limitesIndicados']); $i++): ?>
                        <tr>
                            <td><?php echo $resultado['limitesIndicados'][$i]; ?></td>
                            <td><?php echo $resultado['limitesReales'][$i]; ?></td>
                            <td><?php echo $resultado['puntosMedios'][$i]; ?></td>
                            <td><?php echo $resultado['frecuencias'][$i]; ?></td>
                            <td><?php echo number_format($resultado['frecuenciasRelativas'][$i], 2); ?>%</td>
                            <td><?php echo $resultado['acumMenosDe'][$i]; ?></td>
                            <td><?php echo $resultado['acumMasDe'][$i]; ?></td>
                        </tr>
                    <?php endfor; ?>
                    <tr>
                        <td colspan="3"><strong>TOTAL</strong></td>
                        <td><strong><?php echo array_sum($resultado['frecuencias']); ?></strong></td>
                        <td><strong>100%</strong></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
