<?php include '../shared/header.php'; ?>

<body>


    <div class="container mt-5">
        <!-- Botón Atrás -->
        <a href="../pages/menu.php" class="btn btn-danger mb-3" style="margin-top: 20px;">
            <i class="fas fa-arrow-left"></i> Atrás
        </a>
        <h2 class="text-center mb-4"><i class="fas fa-database"></i> Gestor de Datos</h2>

        <!-- Sección de Importar Datos -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4><i class="fas fa-table"></i> Importar Datos desde Excel</h4>
                        <div class="form-group">
                            <label for="importFile">Seleccionar archivo Excel:</label>
                            <input type="file" id="importFile" class="form-control" accept=".xlsx, .xls">
                        </div>
                        <div class="btn-toolbar mt-3" role="toolbar" aria-label="Toolbar with buttons">
                            <div class="btn-group me-2" role="group" aria-label="First group">
                                <button id="importExcel" class="btn btn-primary">
                                    <i class="fas fa-upload"></i> Importar Excel
                                </button>
                                <button id="saveTableBtn" class="btn btn-success">
                                    <i class="fas fa-save"></i> Guardar Tabla
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Sección de Gráficos -->
            <div class="col-md-6">
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
                            <button class="btn btn-info" id="lineChartBtn">
                                <i class="fas fa-chart-line"></i> Línea
                            </button>
                            <button class="btn btn-info" id="barChartBtn">
                                <i class="fas fa-chart-bar"></i> Barras
                            </button>
                            <button class="btn btn-info" id="pieChartBtn">
                                <i class="fas fa-chart-pie"></i> Pastel
                            </button>
                            <button class="btn btn-info" id="radarChartBtn">
                                <i class="fas fa-chart-area"></i> Radar
                            </button>
                        </div>
                        <button class="btn btn-warning w-100 mt-3" id="graphAllBtn">
                            <i class="fas fa-chart-pie"></i> Graficar Todo
                        </button>
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
                            <canvas id="chartCanvas"></canvas> <!-- Canvas para el gráfico -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!-- Botón para descargar el gráfico -->
                        <button id="downloadChartBtn" class="btn btn-primary">
    <i class="fas fa-download"></i> Descargar PNG
</button>

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para Gráficos Múltiples (Graficar Todo) -->
        <div class="modal fade" id="allChartsModal" tabindex="-1" aria-labelledby="allChartsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl"> <!-- Modal Extra Grande -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="allChartsModalLabel">Todos los Gráficos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="chart-container p-3 shadow-sm bg-white rounded">
                                    <canvas id="lineChartCanvas"></canvas>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="chart-container p-3 shadow-sm bg-white rounded">
                                    <canvas id="barChartCanvas"></canvas>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="chart-container p-3 shadow-sm bg-white rounded">
                                    <canvas id="pieChartCanvas"></canvas>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="chart-container p-3 shadow-sm bg-white rounded">
                                    <canvas id="radarChartCanvas"></canvas>
                                </div>
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
 <!-- Modal para mostrar resultados -->
 <div class="modal fade" id="resultModal" tabindex="-1" role="dialog" aria-labelledby="resultModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title" id="resultModalLabel">Resultados</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Media Aritmética:</strong> <span id="meanResult"></span></p>
                        <p><strong>Moda:</strong> <span id="modeResult"></span></p>
                        <p><strong>Mediana:</strong> <span id="medianResult"></span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.plot.ly/plotly-2.12.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/public/js/graficar_importado.js"></script>
    <script src="/public/js/image_grafico.js"></script>
    <script src="/public/js/medidas.js"></script>
    <script src="/public/js/graficar.js"></script>
    <script src="/public/js/descargartabla.js"></script>



</body>

</html>