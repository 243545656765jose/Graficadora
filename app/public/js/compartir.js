function previewFile(filePath) {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", filePath, true);
    xhr.responseType = "arraybuffer";

    xhr.onload = function (e) {
        if (xhr.status === 200) {
            const data = new Uint8Array(xhr.response);
            const workbook = XLSX.read(data, { type: "array" });

            const firstSheetName = workbook.SheetNames[0];
            const worksheet = workbook.Sheets[firstSheetName];

            const html = XLSX.utils.sheet_to_html(worksheet, { editable: true });

            const tableHtml = `
                <table class="table table-striped table-bordered table-hover">
                    ${html}
                </table>
            `;
            document.getElementById('previewTableContainer').innerHTML = tableHtml;

            const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
            previewModal.show();
        }
    };

    xhr.send();
}
