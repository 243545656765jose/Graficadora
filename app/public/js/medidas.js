$(document).ready(function () {
    // Al hacer clic en el botón de calcular
    $('#calculateBtn').on('click', function () {
        const columnIndex = $('#columnSelect').val();
        if (columnIndex === null) {
            alert('Selecciona una columna para calcular.');
            return;
        }

        const values = [];
        // Recoger los valores de la columna seleccionada
        $('#dataTable tbody tr').each(function () {
            const value = $(this).find('td').eq(columnIndex).text();
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

        // Calcular las estadísticas
        const mean = calculateMean(values);
        const mode = calculateMode(values);
        const median = calculateMedian(values);

        // Mostrar resultados en el modal
        $('#meanResult').text(mean.toFixed(2)); // Media
        $('#modeResult').text(Array.isArray(mode) ? mode.join(', ') : mode); // Moda
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

        // Contar las frecuencias de cada valor
        values.forEach(value => {
            frequency[value] = (frequency[value] || 0) + 1;
            if (frequency[value] > maxFreq) {
                maxFreq = frequency[value];
            }
        });

        // Seleccionar los valores con la frecuencia máxima
        for (let key in frequency) {
            if (frequency[key] === maxFreq && maxFreq > 1) {
                modes.push(parseFloat(key));
            }
        }

        // Determinar si es multimodal o no hay moda
        if (modes.length > 1) {
            return `Multimodal: ${modes.join(', ')}`;
        } else if (modes.length === 1) {
            return modes; // Unimodal con un único valor de moda
        } else {
            return 'No hay moda'; // No hay moda
        }
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
});
