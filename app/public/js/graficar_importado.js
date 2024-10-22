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
