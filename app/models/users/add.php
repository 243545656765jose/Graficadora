<?php
// Incluir el archivo de conexión a la base de datos
$conn = include '../../utils/database.php'; // Ajusta la ruta de acuerdo a tu estructura de carpetas

// Verificar que la conexión se haya establecido correctamente
if (!$conn) {
    die("Error en la conexión a la base de datos.");
}

// Procesar los datos del formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = mysqli_real_escape_string($conn, $_POST['username']);
    $correo = mysqli_real_escape_string($conn, $_POST['email']);
    $contrasena = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Validar que los campos no estén vacíos
    if (empty($nombre) || empty($correo) || empty($contrasena)) {
        echo "Por favor, rellena todos los campos.";
        exit();
    }

    // Cifrar la contraseña
    $contrasena_cifrada = password_hash($contrasena, PASSWORD_BCRYPT);

    // Verificar si el correo ya está registrado
    $sql_check = "SELECT id FROM usuarios WHERE correo = '$correo'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        echo "Este correo ya está registrado.";
    } else {
        // Insertar el nuevo usuario en la base de datos
        $sql = "INSERT INTO usuarios (nombre, correo, contrasena) VALUES ('$nombre', '$correo', '$contrasena_cifrada')";

        if ($conn->query($sql) === TRUE) {
            echo "Registro exitoso. Ahora puedes iniciar sesión.";
            header("Location: /../index.php"); // Redirigir después de un registro exitoso
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}


// Cerrar la conexión
$conn->close();

