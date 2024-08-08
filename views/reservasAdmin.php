<?php
require '../db/auth.php';
checkLogin();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reservaciones</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://bootswatch.com/4/cerulean/bootstrap.min.css">  
    <link rel="stylesheet" href="../css/styleHistorialReservacion.css">
    <link rel="stylesheet" href="../css/style-nav.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/a2dd6045c4.js" crossorigin="anonymous"></script>
</head>
<body>

<header class="header">
    <div class="container-navbar">
        <nav class="navbar">
            <div class="menu-toggle" id="mobile-menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
            <ul class="menu">
                <li><a href="../views/historialReservas.php" class="active"><i class="fas fa-calendar-alt"></i>Reservaciones</a></li>
            </ul>
            <ul class="menu-right">
                <li><a href="../views/mi_perfil.php"><i class="fas fa-user"></i> Mi Perfil</a></li>
                <li><a href="../db/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Salir</a></li>
            </ul>
        </nav>
    </div>
</header>

<div class="contenedor-principal">
    <div class="container mt-5">
        <h1 class="text-center">Reservaciones de Clientes</h1>   
        <p class="text-center">
            En este apartado podrás revisar las reservaciones que están pendientes
            de ser confirmadas o canceladas, así como un historial de las que previamente
            hayan sido confirmadas o canceladas.
        </p>
        <h2 class="encabezado mt-5">Reservaciones Pendientes</h2>
        <div class="accordion" id="reservationsAccordion"></div>

        <h2 class="encabezado mt-3">Reservaciones Confirmadas</h2>
        <div class="accordion" id="confirmedAccordion"></div>

        <h2 class="encabezado mt-3">Reservaciones Canceladas</h2>
        <div class="accordion" id="canceledAccordion"></div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="../javascript/scriptReservasAdmin.js"></script>
<script src="../javascript/script-nav.js"></script>

</body>
</html>