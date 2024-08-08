<?php
require '../db/auth.php';
checkLogin();

// Obtener el nombre del usuario desde la sesión
$user_name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
$user_phone = isset($_SESSION['phone']) ? $_SESSION['phone'] : '';
$user_email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$user_pass = isset($_SESSION['pass']) ? $_SESSION['pass'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://kit.fontawesome.com/a2dd6045c4.js" crossorigin="anonymous"></script> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/style-nav.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                <li><a href="../views/restaurant.php"><i class="fas fa-home"></i>Inicio</a></li>
                <li><a href="../views/historialReservas.php"><i class="fas fa-calendar-alt"></i>Reservaciones</a></li>
            </ul>
            <ul class="menu-right">
                <li><a href="../views/mi_perfil.php" class="active"><i class="fas fa-user"></i> Mi Perfil</a></li>
                <li><a href="../db/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Salir</a></li>
            </ul>
        </nav>
    </div>
</header>
    <section class="todo_mi_perfil">
        <div class="contenedor_reg"> 
            <div class="formulario">
                <form action="../routes/profile_route.php" id="registrationForm" method="POST">
                    <h2>Mi Perfil</h2>
                    
                    <div class="input-contenedor">
                        <i class="fa-solid fa-user"></i>
                        <input type="hidden" name="Id_User" value="<?php echo $_SESSION['user_id']; ?>">
                        <input name="Name" type="text" id="name" value="<?php echo $_SESSION['name']; ?>" required>
                        <label for="name">Nombre Completo</label>
                    </div>
                    <div class="input-contenedor">
                        <i class="fa-solid fa-phone"></i>
                        <input name="Phone" type="tel" id="phone" value="<?php echo $_SESSION['phone']; ?>" required>
                        <label for="phone">Teléfono</label>
                    </div>

                    <div class="input-contenedor">
                        <i class="fa-solid fa-envelope"></i>
                        <input name="Email" type="email" id="email" value="<?php echo $_SESSION['email']; ?>" required>
                        <label for="email">Correo</label>
                    </div>

                    <div class="input-contenedor">
                        <i class="fa-solid fa-lock"></i>
                        <input name="Pass" type="password" id="password" value="<?php echo $_SESSION['pass']; ?>" required>
                        <label for="password">Contraseña</label>
                    </div>

                    <div>
                        <button type="submit" id="registerButton">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script src="../javascript/script-nav.js"></script>
</body>
</html>