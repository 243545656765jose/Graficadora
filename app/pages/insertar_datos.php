<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Gestor de Datos Optimizado</title>
    <style>
        body {
            background-color: #f8f9fa;
        }

        h2 {
            margin-top: 20px;
        }

        .form-control {
            margin-bottom: 15px;
        }

        .modal-header,
        .modal-footer {
            background-color: #343a40;
            color: #fff;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
            cursor: pointer;
        }

        .btn-toolbar {
            margin-bottom: 20px;
        }

        #chartCanvas {
            width: 100%;
            height: 500px;
        }

        .modal-lg-custom {
            max-width: 90%;
        }

        .chart-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .chart-container {
            width: 100%;
            height: 400px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4"><i class="fas fa-database"></i> Gestor de Datos</h2>

        <!-- Sección de Insertar Datos -->
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h4><i class="fas fa-table"></i> Insertar Datos</h4>
                        <div class="form-group">
                            <label for="tableName">Nombre de la tabla:</label>
                            <input type="text" id="tableName" class="form-control" placeholder="Ejemplo: MiTabla">
                        </div>
                        <div class="form-group">
                            <label for="numColumns">Número de columnas:</label>
                            <input type="number" id="numColumns" class="form-control" value="1" min="1">
                        </div>
                        <div class="btn-toolbar">
                            <div class="btn-group me-2">
                                <button id="addRowBtn" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Añadir Fila</button>
                                <button id="createTableBtn" class="btn btn-secondary"><i class="fas fa-plus-circle"></i> Crear Tabla</button>
                            </div>
                            <div class="btn-group me-2">
                                <button id="deleteRowBtn" class="btn btn-danger"><i class="fas fa-minus-circle"></i> Eliminar Fila</button>
                                <button id="deleteColumnBtn" class="btn btn-danger"><i class="fas fa-minus-circle"></i> Eliminar Columna</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección de Gráficos y Cálculos -->
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h4><i class="fas fa-chart-bar"></i> Graficar y Calcular</h4>
                        <div class="form-group">
                            <label for="columnSelect">Seleccionar Columna para Calcular:</label>
                            <select id="columnSelect" class="form-control"></select>
                        </div>
                        <button id="calculateBtn" class="btn btn-success w-100 mb-3">
                            <i class="fas fa-calculator"></i> Calcular Media, Moda y Mediana
                        </button>

                        <div class="d-grid gap-2">
                            <button class="btn btn-info" id="lineChartBtn"><i class="fas fa-chart-line"></i> Línea</button>
                            <button class="btn btn-info" id="barChartBtn"><i class="fas fa-chart-bar"></i> Barras</button>
                            <button class="btn btn-info" id="pieChartBtn"><i class="fas fa-chart-pie"></i> Pastel</button>
                            <button class="btn btn-info" id="radarChartBtn"><i class="fas fa-chart-area"></i> Radar</button>
                        </div>
                        <button class="btn btn-warning w-100 mt-3" id="graphAllBtn"><i class="fas fa-chart-pie"></i> Graficar Todo</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para mostrar resultados -->
        <div class="modal fade" id="resultModal" tabindex="-1" role="dialog" aria-labelledby="resultModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="resultModalLabel">Resultados</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Media:</strong> <span id="meanResult"></span></p>
                        <p><strong>Moda:</strong> <span id="modeResult"></span></p>
                        <p><strong>Mediana:</strong> <span id="medianResult"></span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Datos -->
        <div id="dataTableContainer">
            <h4><i class="fas fa-list-alt"></i> Tabla de Datos</h4>
            <table class="table table-hover table-bordered table-striped" id="dataTable">
                <thead class="table-dark">
                    <tr></tr>
                </thead>
                <tbody>
                    <!-- Filas dinámicas aquí -->
                </tbody>
            </table>
        </div>

        <!-- Modal para Gráficos Individuales -->
        <div class="modal fade" id="chartModal" tabindex="-1" aria-labelledby="chartModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="chartModalLabel">Gráfico</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="chartContainer">
                            <canvas id="chartCanvas"></canvas> <!-- Canvas para Chart.js -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="downloadBtn" class="btn btn-primary"><i class="fas fa-download"></i> Descargar PNG</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para Gráficos Subdivididos (Graficar Todo) -->
        <div class="modal fade" id="allChartsModal" tabindex="-1" aria-labelledby="allChartsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg-custom">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="allChartsModalLabel">Todos los Gráficos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="chart-grid">
                            <div class="chart-container">
                                <canvas id="lineChartCanvas"></canvas>
                                <button id="downloadLineChart" class="btn btn-primary mt-2"><i class="fas fa-download"></i> Descargar Gráfico Línea</button>
                            </div>
                            <div class="chart-container">
                                <canvas id="barChartCanvas"></canvas>
                                <button id="downloadBarChart" class="btn btn-primary mt-2"><i class="fas fa-download"></i> Descargar Gráfico Barras</button>
                            </div>
                            <div class="chart-container">
                                <canvas id="pieChartCanvas"></canvas>
                                <button id="downloadPieChart" class="btn btn-primary mt-2"><i class="fas fa-download"></i> Descargar Gráfico Pastel</button>
                            </div>
                            <div class="chart-container">
                                <canvas id="radarChartCanvas"></canvas>
                                <button id="downloadRadarChart" class="btn btn-primary mt-2"><i class="fas fa-download"></i> Descargar Gráfico Radar</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/public/js/graficar.js"></script>
</body>

</html>
