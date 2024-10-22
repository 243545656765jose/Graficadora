<?php
// Establecer conexión a la base de datos
$conex = mysqli_connect('127.0.0.1', 'root', 'root!@123', 'graficadora');

// Verificar si la conexión ha fallado
if (!$conex) {
    die('<h1>Error al conectar a la base de datos: ' . mysqli_connect_error() . '</h1>');
}

// Si la conexión es exitosa, retornamos la conexión
return $conex;
