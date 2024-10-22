<?php
$targetDir = "../../uploads/"; // Directorio donde se guardarán los archivos
$targetFile = $targetDir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// Verifica si el archivo es un archivo Excel
if($fileType != "xlsx" && $fileType != "xls") {
    echo "Lo siento, solo se permiten archivos Excel (.xlsx, .xls).";
    $uploadOk = 0;
}

// Verifica si $uploadOk es 0 por algún error
if ($uploadOk == 0) {
    echo "Lo siento, el archivo no se ha subido.";
} else {
    // Si todo está bien, intenta subir el archivo
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
        echo "El archivo ". htmlspecialchars( basename( $_FILES["file"]["name"])). " ha sido cargado.";
        // Redirigir de vuelta a la página de carga
        header("Location: ../../pages/compartir.php");
        exit();
    } else {
        echo "Lo siento, hubo un error al cargar tu archivo.";
    }
}
?>
