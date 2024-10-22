$(document).ready(function () {
    // Calcular Media, Moda y Mediana
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

        const mean = calculateMean(values);
        const mode = calculateMode(values);
        const median = calculateMedian(values);

        // Mostrar resultados en el modal
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
   
});
// Función para crear la tabla

$(document).ready(function () {
    // Función para importar el archivo Excel y mostrar en tabla
    $('#importExcel').on('click', function () {
        const fileInput = document.getElementById('importFile');
        const file = fileInput.files[0];

        if (!file) {
            alert('Por favor selecciona un archivo.');
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            const data = new Uint8Array(e.target.result);
            const workbook = XLSX.read(data, { type: 'array' });
            const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
            const jsonData = XLSX.utils.sheet_to_json(firstSheet, { header: 1 });

            if (jsonData.length === 0) {
                alert('El archivo está vacío o tiene un formato no válido.');
                return;
            }

            // Limpiar tabla antes de agregar datos
            $('#dataTable thead tr').empty();
            $('#dataTable tbody').empty();
            $('#columnSelect').empty(); // Limpiar el combo box

            // Agregar encabezados (primera fila del Excel)
            const headers = jsonData[0];
            headers.forEach(function (header) {
                $('#dataTable thead tr').append(`<th>${header}</th>`); // Agregar encabezados a la tabla
                $('#columnSelect').append(`<option value="${headers.indexOf(header)}">${header}</option>`); // Agregar al combo box
            });

            // Agregar filas de datos
            for (let i = 1; i < jsonData.length; i++) {
                let row = '<tr>';
                jsonData[i].forEach(function (cell) {
                    row += `<td>${cell}</td>`;
                });
                row += '</tr>';
                $('#dataTable tbody').append(row);
            }
        };

        reader.readAsArrayBuffer(file);
    });
});
