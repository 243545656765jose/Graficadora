$(document).ready(function () {
    let selectedRow = null;
    let selectedColumnIndex = null; // Variable para almacenar el índice de la columna seleccionada

    // Función para actualizar el combo box con los nombres de las columnas
    function updateColumnSelect() {
        const $select = $('#columnSelect');
        $select.empty(); // Limpiar el combo box
        $('#dataTable thead th').each(function (index) {
            const columnName = $(this).text().trim();
            $select.append(`<option value="${index}">${columnName}</option>`);
        });
    }

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
            const columnName = `Columna ${i + 1}`;
            tableHead.append(`<th contenteditable="true">${columnName}</th>`);
        }

        // Añadir una fila inicial
        addRow(numColumns);

        // Actualizar el combo box con los nombres de las columnas
        updateColumnSelect();
    });

    // Función para añadir una fila
    $('#addRowBtn').on('click', function () {
        const numColumns = $('#dataTable thead th').length;
        addRow(numColumns);
    });

    function addRow(numColumns) {
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

    // Función para agregar una columna
    $('#addColumnBtn').on('click', function () {
        const numColumns = $('#dataTable thead th').length;
        const newColumnIndex = numColumns;
        const newColumnName = `Columna ${newColumnIndex + 1}`;
        
        // Agregar encabezado de columna
        $('#dataTable thead tr').append(`<th contenteditable="true">${newColumnName}</th>`);

        // Agregar celdas vacías a todas las filas
        $('#dataTable tbody tr').each(function () {
            $(this).append('<td contenteditable="true"></td>');
        });

        // Actualizar el combo box con los nombres de las columnas
        updateColumnSelect(); // Actualizar el combo box después de agregar una columna
    });

    // Resaltar y seleccionar una columna al hacer clic en el encabezado
    $('#dataTable').on('click', 'th', function () {
        // Remover la clase seleccionada de todos los encabezados
        $('#dataTable th').removeClass('selected-column');
        
        // Resaltar el encabezado seleccionado
        $(this).addClass('selected-column');

        // Obtener el índice de la columna seleccionada
        selectedColumnIndex = $(this).index();
    });

    // Eliminar la columna seleccionada por el usuario
    $('#deleteColumnBtn').on('click', function () {
        if (selectedColumnIndex !== null) {
            // Eliminar la columna del encabezado
            $('#dataTable thead th').eq(selectedColumnIndex).remove();
            
            // Eliminar las celdas correspondientes en cada fila
            $('#dataTable tbody tr').each(function () {
                $(this).find('td').eq(selectedColumnIndex).remove();
            });

            // Resetear la selección de la columna
            selectedColumnIndex = null;

            // Actualizar el combo box después de eliminar una columna
            updateColumnSelect(); // Actualizar el combo box después de eliminar una columna
        } else {
            alert('Selecciona una columna para eliminar.');
        }
    });

    // CSS para resaltar la columna seleccionada
    $('<style>.selected-column { background-color: #ffcccc; }</style>').appendTo('head');
});
$(document).ready(function () {
    $('#compartirbtn').on('click', function () {
        // Redirigir a compartir.php para descargar y guardar el archivo Excel
        window.location.href = 'compartir.php';
    });
});
