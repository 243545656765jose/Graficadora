<?php
   $conex = mysqli_connect('127.0.0.1', 'root', 'root!@123','web_projectd');
if (!$conex) {
    echo '<h1>Error al conectar a la base de datos: '.mysqli_connect_error().'</h1>';
} else {
}
return $conex;