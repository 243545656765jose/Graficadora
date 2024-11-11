document.addEventListener("DOMContentLoaded", function() {
    const downloadBtn = document.getElementById("downloadBtn");
    const chartCanvas = document.getElementById("chartCanvas");

    downloadBtn.addEventListener("click", function() {
        // Verificar que el canvas exista y esté renderizado
        if (chartCanvas) {
            const link = document.createElement("a");
            link.href = chartCanvas.toDataURL("image/png");
            link.download = "grafico.png"; // Nombre del archivo descargado
            link.click();
        } else {
            alert("El gráfico no está disponible para descargar.");
        }
    });
});
