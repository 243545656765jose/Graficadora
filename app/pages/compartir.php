<?php include '../shared/header.php'; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <title>Cargar Archivos Excel</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <link rel="stylesheet" href="/public/css/compartir.css">

<body>
    <div class="container mt-5">
    <a href="../pages/menu.php" class="btn btn-danger mb-3" style="margin-top: 20px;">
            <i class="fas fa-arrow-left"></i> Atrás
        </a>
        <h2 class="text-center mb-4"><i class="fas fa-file-excel"></i> Cargar Archivos Excel</h2>

        <form action="../models/users/upload.php" method="POST" enctype="multipart/form-data" class="mb-4">
            <div class="mb-3">
                <label for="file" class="form-label">Selecciona un archivo Excel:</label>
                <input type="file" class="form-control" name="file" id="file" accept=".xlsx, .xls" required>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> Cargar Archivo</button>
        </form>

        <h4><i class="fas fa-list-alt"></i> Archivos Subidos:</h4>
        <ul class="list-group">
            <?php
            $directory = '../uploads/'; // Ruta donde se guardan los archivos
            if (is_dir($directory)) {
                $files = scandir($directory);
                foreach ($files as $file) {
                    if ($file !== '.' && $file !== '..') {
                        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>
                                <span>$file</span>
                                <div>
                                    <a href='$directory$file' class='btn btn-success btn-sm' download>
                                        <i class='fas fa-download'></i> Descargar
                                    </a>
                                    <button class='btn btn-info btn-sm' onclick='previewFile(\"$directory$file\")'>
                                        <i class='fas fa-eye'></i> Vista Previa
                                    </button>
                                </div>
                              </li>";
                    }
                }
            }
            ?>
        </ul>
    </div>

    <!-- Modal para Vista Previa -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">Vista Previa del Archivo Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="previewTableContainer" class="table-responsive"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/js/compartir.js"></script>
</body>
</html>
