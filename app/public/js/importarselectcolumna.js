$(document).ready(function () {
    // Cargar los nombres de las columnas en el combo box
    function loadColumnNames() {
        const columnSelect = $('#columnSelect');
        columnSelect.empty(); // Limpiar las opciones existentes

        $('#dataTable thead tr th').each(function () {
            const columnName = $(this).text().trim();
            if (columnName) {
                columnSelect.append(`<option value="${columnName}">${columnName}</option>`);
            }
        });
    }

    // Calcular Media, Moda y Mediana
    $('#calculateBtn').on('click', function () {
        const columnName = $('#columnSelect').val();
        if (!columnName) {
            alert('Selecciona una columna para calcular.');
            return;
        }

        const values = [];
        // Recoger los valores de la columna seleccionada
        $('#dataTable tbody tr').each(function () {
            const index = $('#dataTable thead tr th').index($(`th:contains('${columnName}')`));
            const value = $(this).find('td').eq(index).text();
            const parsedValue = parseFloat(value);

            // Validar que el valor sea un número
            if (!isNaN(parsedValue)) {
                values.push(parsedValue);
            }
        });

        if (values.length === 0) {
            alert('No hay datos válidos en la columna seleccionada.');
            return;
        }

        const mean = calculateMean(values);
        const mode = calculateMode(values);
        const median = calculateMedian(values);

        // Mostrar resultados en el modal (implementa el modal según tu estructura)
        $('#meanResult').text(mean.toFixed(2)); // Media
        $('#modeResult').text(mode.length ? mode.join(', ') : 'No hay moda'); // Moda
        $('#medianResult').text(median.toFixed(2)); // Mediana

        // Mostrar el modal con los resultados
        $('#resultModal').modal('show');
    });

    // Función para calcular la media
    function calculateMean(values) {
        const total = values.reduce((sum, value) => sum + value, 0);
        return total / values.length;
    }

    // Función para calcular la moda
    function calculateMode(values) {
        const frequency = {};
        let maxFreq = 0;
        const modes = [];

        values.forEach(value => {
            frequency[value] = (frequency[value] || 0) + 1;
            if (frequency[value] > maxFreq) {
                maxFreq = frequency[value];
            }
        });

        for (let key in frequency) {
            if (frequency[key] === maxFreq && maxFreq > 1) {
                modes.push(key); // Solo agrega si hay más de una ocurrencia
            }
        }

        return modes;
    }

    // Función para calcular la mediana
    function calculateMedian(values) {
        values.sort((a, b) => a - b); // Ordenar los valores
        const mid = Math.floor(values.length / 2);

        if (values.length % 2 === 0) {
            // Si hay un número par de valores, la mediana es el promedio de los dos del medio
            return (values[mid - 1] + values[mid]) / 2;
        } else {
            // Si hay un número impar de valores, la mediana es el del medio
            return values[mid];
        }
    }

    // Cargar nombres de columnas al inicio
    loadColumnNames();
});
