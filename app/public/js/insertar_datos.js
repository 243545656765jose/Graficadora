$(document).ready(function () {
    let rowCount = 0;
    let selectedRow = null;

    // Crear tabla dinámica con columnas y filas
    $('#createTableBtn').on('click', function () {
        const numColumns = parseInt($('#numColumns').val());
        const tableHead = $('#dataTable thead tr');
        const tableBody = $('#dataTable tbody');

        // Vaciar las filas y columnas anteriores
        tableHead.empty();
        tableBody.empty();
        $('#columnSelect').empty();

        // Crear encabezados de la tabla
        for (let i = 0; i < numColumns; i++) {
            const columnName = `Columna ${i + 1}`;
            tableHead.append(`<th contenteditable="true">${columnName}</th>`);
            $('#columnSelect').append(`<option value="${i}">${columnName}</option>`);
        }

        // Añadir una fila inicial
        addRow(numColumns);
    });

    // Función para añadir una fila
    $('#addRowBtn').on('click', function () {
        const numColumns = $('#dataTable thead th').length;
        addRow(numColumns);
    });

    function addRow(numColumns) {
        rowCount++;
        let row = `<tr>`;
        for (let i = 0; i < numColumns; i++) {
            row += `<td contenteditable="true"></td>`;
        }
        row += `</tr>`;
        $('#dataTable tbody').append(row);
    }

    // Seleccionar una fila al hacer clic
    $('#dataTable tbody').on('click', 'tr', function () {
        $('#dataTable tbody tr').removeClass('table-active'); // Quitar la selección de otras filas
        $(this).addClass('table-active'); // Resaltar fila seleccionada
        selectedRow = $(this); // Guardar la fila seleccionada
    });

    // Eliminar la fila seleccionada
    $('#deleteRowBtn').on('click', function () {
        if (selectedRow) {
            selectedRow.remove();
            selectedRow = null;
        } else {
            alert('Selecciona una fila para eliminar.');
        }
    });

    // Eliminar la última columna
    $('#deleteColumnBtn').on('click', function () {
        $('#dataTable thead th:last').remove();
        $('#dataTable tbody tr').each(function () {
            $(this).find('td:last').remove();
        });
        $('#columnSelect option:last').remove();
    });

    // Función para calcular media, moda y mediana
    $('#calculateBtn').on('click', function () {
        const selectedColumnIndex = parseInt($('#columnSelect').val()); // Obtener índice de la columna seleccionada
        const columnData = [];

        // Recopilar los datos de la columna seleccionada
        $('#dataTable tbody tr').each(function () {
            const cellValue = $(this).find('td').eq(selectedColumnIndex).text().trim(); // Obtener valor de la celda
            if (!isNaN(cellValue) && cellValue !== '') {
                columnData.push(parseFloat(cellValue)); // Solo se agregan números válidos
            }
        });

        // Validar si hay datos válidos
        if (columnData.length === 0) {
            alert('No hay datos válidos en esta columna para realizar los cálculos.');
            return;
        }

        // Calcular media, moda y mediana
        const mean = calculateMean(columnData);
        const mode = calculateMode(columnData);
        const median = calculateMedian(columnData);

        // Mostrar los resultados en el modal
        $('#meanResult').text(`Media: ${mean}`);
        $('#modeResult').text(`Moda: ${mode}`);
        $('#medianResult').text(`Mediana: ${median}`);
        $('#resultModal').modal('show'); // Mostrar el modal con los resultados
    });

    // Funciones para calcular media, moda y mediana

    // Función para calcular la media aritmética
    function calculateMean(data) {
        const sum = data.reduce((acc, val) => acc + val, 0); // Sumar todos los valores
        return (sum / data.length).toFixed(2); // Devolver el promedio con dos decimales
    }

    // Función para calcular la moda
    function calculateMode(data) {
        const frequency = {};
        let maxFreq = 0;
        let mode = [];

        // Calcular la frecuencia de cada número
        data.forEach(num => {
            frequency[num] = (frequency[num] || 0) + 1;
            if (frequency[num] > maxFreq) {
                maxFreq = frequency[num];
                mode = [num];
            } else if (frequency[num] === maxFreq) {
                mode.push(num); // Si hay varias modas
            }
        });

        return mode.join(', '); // Retorna las modas encontradas
    }

    // Función para calcular la mediana
    function calculateMedian(data) {
        data.sort((a, b) => a - b); // Ordenar los valores de menor a mayor
        const mid = Math.floor(data.length / 2); // Encontrar el índice del medio

        // Si es impar, devolver el valor del medio, si es par, el promedio de los dos valores del medio
        if (data.length % 2 === 0) {
            return ((data[mid - 1] + data[mid]) / 2).toFixed(2);
        } else {
            return data[mid].toFixed(2);
        }
    }

    // Escuchar cambios en los nombres de las columnas y actualizar el combo box
    $('#dataTable').on('input', 'th', function () {
        updateColumnSelect();
    });

    // Función para actualizar el combo box cuando cambian los nombres de las columnas
    function updateColumnSelect() {
        $('#columnSelect').empty(); // Limpiar el combo box
        $('#dataTable thead th').each(function (index) {
            const columnName = $(this).text().trim(); // Obtener el nombre actualizado de la columna
            $('#columnSelect').append(`<option value="${index}">${columnName}</option>`); // Añadir opción
        });
    }
});
