// Guardar Tabla como Excel
$('#saveTableBtn').on('click', function () {
    const tableData = [];
    
    // Recoger encabezados de la tabla
    const headers = [];
    $('#dataTable thead th').each(function () {
        headers.push($(this).text().trim());
    });
    tableData.push(headers);

    // Recoger los valores de la tabla
    $('#dataTable tbody tr').each(function () {
        const row = [];
        $(this).find('td').each(function () {
            row.push($(this).text().trim());
        });
        tableData.push(row);
    });

    // Crear un nuevo libro de Excel
    const wb = XLSX.utils.book_new();
    const ws = XLSX.utils.aoa_to_sheet(tableData); // Convierte la matriz de datos a una hoja

    XLSX.utils.book_append_sheet(wb, ws, "Datos"); // Agregar la hoja al libro

    // Descargar el archivo Excel
    XLSX.writeFile(wb, 'tabla_datos.xlsx');
});
