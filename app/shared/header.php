<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/actions/users/validationsesion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/actions/users/validationsesion_user.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AcuRey Gaming</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="stylesheet" href="../public/css/header.css">
</head>
<body>
 <nav class="navbar navbar-expand-lg navbar-custom">
        <a class="navbar-brand" href="#">
            <img src="../public/img/logoP.webp" alt="Logo"> AcuRey Gaming
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/app/pages/menu.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="userPerfil.php">Perfil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/app/actions/users/logout.php">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </nav>
