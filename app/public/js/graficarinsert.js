$(document).ready(function() {
    let myChart;

    // Lista de colores intensos y ampliada para más diferenciación
    const colorPalette = [
        'rgba(255, 87, 51, 0.8)',    // Rojo brillante
        'rgba(54, 162, 235, 0.8)',   // Azul fuerte
        'rgba(255, 206, 86, 0.8)',   // Amarillo brillante
        'rgba(75, 192, 192, 0.8)',   // Turquesa
        'rgba(153, 102, 255, 0.8)',  // Púrpura fuerte
        'rgba(255, 159, 64, 0.8)',   // Naranja brillante
        'rgba(46, 204, 113, 0.8)',   // Verde vibrante
        'rgba(231, 76, 60, 0.8)',    // Rojo vibrante
        'rgba(52, 152, 219, 0.8)',   // Azul intenso
        'rgba(142, 68, 173, 0.8)',   // Púrpura oscuro
        'rgba(243, 156, 18, 0.8)',   // Amarillo intenso
        'rgba(241, 196, 15, 0.8)',   // Mostaza
        'rgba(26, 188, 156, 0.8)',   // Verde azulado
        'rgba(39, 174, 96, 0.8)',    // Verde bosque
        'rgba(192, 57, 43, 0.8)',    // Rojo oscuro
        'rgba(142, 68, 173, 0.8)',   // Violeta oscuro
        'rgba(52, 73, 94, 0.8)',     // Azul grisáceo
        'rgba(243, 156, 18, 0.8)',   // Naranja fuerte
        'rgba(211, 84, 0, 0.8)',     // Naranja oscuro
        'rgba(22, 160, 133, 0.8)',   // Verde profundo
        'rgba(44, 62, 80, 0.8)',     // Azul noche
    ];

    // Función para obtener colores de la paleta de forma cíclica
    function getColor(index) {
        return colorPalette[index % colorPalette.length];
    }

    // Función para obtener los datos de la tabla por filas, usando la primera columna como etiquetas
    function getTableData() {
        const columnNames = [];
        const rows = [];
        const labels = [];

        // Obtener los nombres de las columnas
        $('#dataTable thead th').each(function() {
            columnNames.push($(this).text().trim());
        });

        // Procesar cada fila de la tabla
        $('#dataTable tbody tr').each(function() {
            const rowData = {};
            $(this).find('td').each(function(index) {
                const cellValue = $(this).text().trim();
                
                if (index === 0) {
                    labels.push(cellValue);
                } else {
                    rowData[columnNames[index]] = parseFloat(cellValue) || 0;
                }
            });
            rows.push(rowData);
        });

        return { columnNames: columnNames.slice(1), rows, labels };
    }

    // Función para dibujar el gráfico en el canvas de Chart.js
    function drawChart(chartType) {
        const { columnNames, rows, labels } = getTableData();

        // Obtener el título, etiquetas y datos personalizados
        const chartTitle = $('#nombregrafico').val() || 'Gráfico Personalizado';
        const xAxisTitle = $('#etiquetas').val() || 'Categorías';
        const yAxisTitle = $('#datos').val() || 'Valores';

        // Crear datasets con colores específicos de la paleta
        const datasets = columnNames.map((columnName, index) => {
            return {
                label: columnName,
                data: rows.map(row => row[columnName]),
                backgroundColor: chartType === 'line' ? getColor(index) : getColor(index),
                borderColor: getColor(index),
                borderWidth: 2,
                fill: chartType !== 'line'
            };
        });

        const ctx = document.getElementById('chartCanvas').getContext('2d');

        // Destruye el gráfico anterior si existe
        if (myChart) {
            myChart.destroy();
        }

        // Crear el gráfico con opciones avanzadas y personalización específica
        myChart = new Chart(ctx, {
            type: chartType,
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            color: '#333',
                            font: {
                                size: 14,
                                family: 'Arial'
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: chartTitle,
                        color: '#333',
                        font: {
                            size: 18,
                            weight: 'bold'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.dataset.label}: ${context.raw}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: xAxisTitle,
                            color: '#666'
                        },
                        ticks: {
                            color: '#666'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: yAxisTitle,
                            color: '#666'
                        },
                        ticks: {
                            color: '#666'
                        }
                    }
                }
            }
        });
    }

    // Eventos para cada botón de gráfico
    $('#lineChartBtn').on('click', function() {
        drawChart('line');
        $('#chartModal').modal('show');
    });

    $('#barChartBtn').on('click', function() {
        drawChart('bar');
        $('#chartModal').modal('show');
    });

    $('#pieChartBtn').on('click', function() {
        drawChart('pie');
        $('#chartModal').modal('show');
    });

    $('#radarChartBtn').on('click', function() {
        drawChart('radar');
        $('#chartModal').modal('show');
    });
});
