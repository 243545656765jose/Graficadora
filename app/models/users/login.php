<?php
session_start();

// Incluir el archivo de conexión a la base de datos
$conn = include '../../utils/database.php'; // Ajusta la ruta a tu archivo de conexión

// Procesar el formulario cuando se envíe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escapar las entradas para evitar inyección SQL
    $nombre = mysqli_real_escape_string($conn, $_POST['username']);
    $contrasena = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Consulta para obtener el usuario
    $sql = "SELECT * FROM usuarios WHERE nombre = '$nombre'";
    $result = $conn->query($sql);
    
    // Verificar si se encontró el usuario
    if ($result->num_rows > 0) {
        // Obtener el registro del usuario
        $row = $result->fetch_assoc();
        $hashed_password = $row['contrasena']; // La contraseña cifrada en la base de datos
        
        // Verificar la contraseña ingresada con la almacenada
        if (password_verify($contrasena, $hashed_password)) {
            // Contraseña correcta, establecer sesión
            $_SESSION['user'] = $row['nombre']; // Puedes almacenar más datos si lo deseas
            $_SESSION['user_id'] = $row['id']; // ID del usuario en la base de datos
            
            // Redirigir al dashboard o página principal
            header("Location: /../../pages/menu.php"); // Redirigir a menu.php en la misma carpeta
            exit();
        } else {
            // Contraseña incorrecta
            echo "La contraseña es incorrecta.";
        }
    } else {
        // Usuario no encontrado
        echo "Usuario no encontrado.";
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
