$(document).ready(function () {
    let charts = {}; // Para almacenar gráficos individuales y múltiples

    // Función para actualizar el combo box con los nombres de las columnas
    function updateColumnSelect() {
        const $select = $('#columnSelect');
        $select.empty(); // Limpiar el combo box
        $('#dataTable thead th').each(function (index) {
            const columnName = $(this).text().trim();
            $select.append(`<option value="${index}">${columnName}</option>`);
        });
    }

    // Detectar cambios en los nombres de las columnas (cuando se editan)
    $('#dataTable').on('input', 'thead th', function () {
        updateColumnSelect(); // Llamar a la función para actualizar el combo box
    });

    // Función para agregar fila dinámica
    $('#addRowBtn').on('click', function () {
        const numColumns = $('#dataTable thead th').length;
        if (numColumns === 0) {
            alert('Primero debes crear una tabla.');
            return;
        }
        let row = '<tr>';
        for (let i = 0; i < numColumns; i++) {
            row += `<td contenteditable="true"></td>`;
        }
        row += '</tr>';
        $('#dataTable tbody').append(row);
    });

    // Crear tabla dinámica con columnas y filas
    $('#createTableBtn').on('click', function () {
        const numColumns = parseInt($('#numColumns').val());
        const tableHead = $('#dataTable thead tr');
        const tableBody = $('#dataTable tbody');

        // Vaciar las filas y columnas anteriores
        tableHead.empty();
        tableBody.empty();

        // Crear encabezados de la tabla
        for (let i = 0; i < numColumns; i++) {
            tableHead.append(`<th contenteditable="true">Columna ${i + 1}</th>`);
        }

        // Añadir una fila inicial
        addRow(numColumns);

        // Actualizar el combo box con los nombres de las columnas
        updateColumnSelect();
    });

    // Función para añadir una fila a la tabla
    function addRow(numColumns) {
        let row = '<tr>';
        for (let i = 0; i < numColumns; i++) {
            row += `<td contenteditable="true"></td>`;
        }
        row += '</tr>';
        $('#dataTable tbody').append(row);
    }

    // Función para mostrar gráficos individuales
    function showChart(chartType) {
        const columnCount = $('#dataTable thead th').length; // Número de columnas
        const rowCount = $('#dataTable tbody tr').length; // Número de filas

        if (columnCount < 2 || rowCount === 0) {
            alert('Se necesitan al menos dos columnas y una fila para graficar.');
            return;
        }

        const labels = [];
        const datasets = [];

        // Obtener etiquetas de la primera columna (para el eje X)
        $('#dataTable tbody tr').each(function () {
            const label = $(this).find('td').eq(0).text().trim();
            if (label) {
                labels.push(label); // Usamos el contenido de la primera columna como etiquetas (X)
            }
        });

        // Obtener los datos de las otras columnas (para el eje Y)
        for (let colIndex = 1; colIndex < columnCount; colIndex++) {
            let data = [];
            $('#dataTable tbody tr').each(function () {
                const value = parseFloat($(this).find('td').eq(colIndex).text());
                if (!isNaN(value)) {
                    data.push(value);
                }
            });

            if (data.length > 0) {
                datasets.push({
                    label: $('#dataTable thead th').eq(colIndex).text(), // Nombre de la columna como etiqueta
                    data: data,
                    backgroundColor: generatePredefinedColors(data.length),
                    borderColor: generatePredefinedBorderColors(data.length),
                    borderWidth: 2,
                    fill: false
                });
            }
        }

        if (datasets.length === 0) {
            alert('No se encontraron datos válidos para graficar.');
            return;
        }

        // Destruir gráfico anterior si existe
        if (charts.individual) {
            charts.individual.destroy();
        }

        // Crear el gráfico individual con Chart.js
        const ctx = document.getElementById('chartCanvas').getContext('2d');
        charts.individual = new Chart(ctx, {
            type: chartType,
            data: {
                labels: labels, // Etiquetas basadas en la primera columna (eje X)
                datasets: datasets // Datos de las columnas restantes (eje Y)
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        enabled: true,
                        callbacks: {
                            label: function (context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.raw ? context.raw.toFixed(2) : '';
                                return label;
                            }
                        }
                    },
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            color: '#333'
                        }
                    }
                },
                scales: chartType !== 'pie' ? {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Valores'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Etiquetas'
                        }
                    }
                } : {},
                animation: {
                    duration: 1000,
                    easing: 'easeInOutCubic'
                }
            }
        });

        // Mostrar el modal con el gráfico individual
        $('#chartModal').modal('show');

        // Configurar el botón para descargar el gráfico individual como PNG
        $('#downloadBtn').on('click', function () {
            const link = document.createElement('a');
            link.href = charts.individual.toBase64Image();
            link.download = 'individual_chart.png';
            link.click();
        });
    }

    // Crear gráficos múltiples en el modal subdividido
    function createCharts(labels, datasets) {
        const ctxLine = document.getElementById('lineChartCanvas').getContext('2d');
        const ctxBar = document.getElementById('barChartCanvas').getContext('2d');
        const ctxPie = document.getElementById('pieChartCanvas').getContext('2d');
        const ctxRadar = document.getElementById('radarChartCanvas').getContext('2d');

        if (charts.line) charts.line.destroy();
        if (charts.bar) charts.bar.destroy();
        if (charts.pie) charts.pie.destroy();
        if (charts.radar) charts.radar.destroy();

        charts.line = new Chart(ctxLine, {
            type: 'line',
            data: { labels, datasets },
            options: { responsive: true, maintainAspectRatio: false }
        });

        charts.bar = new Chart(ctxBar, {
            type: 'bar',
            data: { labels, datasets },
            options: { responsive: true, maintainAspectRatio: false }
        });

        charts.pie = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: datasets[0].data,
                    backgroundColor: generatePredefinedColors(labels.length),
                    borderColor: generatePredefinedBorderColors(labels.length),
                    borderWidth: 1
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });

        charts.radar = new Chart(ctxRadar, {
            type: 'radar',
            data: { labels, datasets },
            options: { responsive: true, maintainAspectRatio: false }
        });

        $('#allChartsModal').modal('show');

        // Descargar gráficos múltiples como PNG
        $('#downloadLineChart').on('click', function () {
            const link = document.createElement('a');
            link.href = charts.line.toBase64Image();
            link.download = 'line_chart.png';
            link.click();
        });

        $('#downloadBarChart').on('click', function () {
            const link = document.createElement('a');
            link.href = charts.bar.toBase64Image();
            link.download = 'bar_chart.png';
            link.click();
        });

        $('#downloadPieChart').on('click', function () {
            const link = document.createElement('a');
            link.href = charts.pie.toBase64Image();
            link.download = 'pie_chart.png';
            link.click();
        });

        $('#downloadRadarChart').on('click', function () {
            const link = document.createElement('a');
            link.href = charts.radar.toBase64Image();
            link.download = 'radar_chart.png';
            link.click();
        });
    }

    // Botones para gráficos individuales
    $('#lineChartBtn').on('click', function () {
        showChart('line');
    });

    $('#barChartBtn').on('click', function () {
        showChart('bar');
    });

    $('#pieChartBtn').on('click', function () {
        showChart('pie');
    });

    $('#radarChartBtn').on('click', function () {
        showChart('radar');
    });

    // Botón para graficar todo
    $('#graphAllBtn').on('click', graphAll);

    function graphAll() {
        const columnCount = $('#dataTable thead th').length;
        const rowCount = $('#dataTable tbody tr').length;

        if (columnCount < 2 || rowCount === 0) {
            alert('Se necesitan al menos dos columnas y una fila para graficar.');
            return;
        }

        const labels = [];
        const datasets = [];

        // Obtener etiquetas de la primera columna (para el eje X)
        $('#dataTable tbody tr').each(function () {
            const label = $(this).find('td').eq(0).text().trim();
            if (label) {
                labels.push(label);
            }
        });

        // Obtener los datos de las otras columnas (para el eje Y)
        for (let colIndex = 1; colIndex < columnCount; colIndex++) {
            let data = [];
            $('#dataTable tbody tr').each(function () {
                const value = parseFloat($(this).find('td').eq(colIndex).text());
                if (!isNaN(value)) {
                    data.push(value);
                }
            });

            if (data.length > 0) {
                datasets.push({
                    label: $('#dataTable thead th').eq(colIndex).text(),
                    data: data,
                    backgroundColor: generatePredefinedColors(data.length),
                    borderColor: generatePredefinedBorderColors(data.length),
                    borderWidth: 2,
                    fill: false
                });
            }
        }

        if (datasets.length === 0) {
            alert('No se encontraron datos válidos para graficar.');
            return;
        }

        // Crear gráficos en el modal subdividido
        createCharts(labels, datasets);
    }

    // Función para generar colores predefinidos
    function generatePredefinedColors(count) {
        const colors = ['rgba(255, 99, 132, 0.6)', 'rgba(54, 162, 235, 0.6)', 'rgba(255, 206, 86, 0.6)', 'rgba(75, 192, 192, 0.6)', 'rgba(153, 102, 255, 0.6)', 'rgba(255, 159, 64, 0.6)'];
        return colors.slice(0, count);
    }

    // Función para generar colores de borde predefinidos
    function generatePredefinedBorderColors(count) {
        const borderColors = ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'];
        return borderColors.slice(0, count);
    }
});
