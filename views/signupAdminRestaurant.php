<?php
require '../db/auth.php';
checkLogin();

require '../controllers/singupAdminRestaurant_controller.php';

$ultimoRestaurante = obtenerUltimoRestaurante();
$errorMensaje = "";

$showRegisterRestaurant = false;
if (isset($_SESSION['showRegisterRestaurant']) && $_SESSION['showRegisterRestaurant'] === true) {
    $showRegisterRestaurant = true; // Cambiar a verdadero si es el super administrador
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://kit.fontawesome.com/a2dd6045c4.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>Registrar administrador</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <!-- Navegación -->
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
                    <?php if (!$showRegisterRestaurant): ?>
                        <li><a href="../views/historialReservas.php"><i class="fas fa-calendar-alt"></i>Reservaciones</a></li>
                    <?php endif; ?>
                        <?php if ($showRegisterRestaurant): ?>
                            <li><a href="../views/signup_restaurant.php" class="active"><i class="fa-solid fa-circle-plus"></i>Registrar Restaurante</a></li>
                        <?php endif; ?>
                </ul>
                <ul class="menu-right">
                    <li><a href="../views/mi_perfil.php"><i class="fas fa-user"></i> Mi Perfil</a></li>
                    <li><a href="../db/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Salir</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <section class="todo_reg">
        <div class="contenedor_reg"> 
            <div class="formulario">
                <form action="../routes/signupAdminRestaurant_route.php" method="POST">
                    <h2>Administrador</h2>
                    <?php if (!empty($errorMensaje)): ?>
                        <div class="error-message" style="color: whit;">
                            <?php echo htmlspecialchars($errorMensaje); ?>
                        </div>
                    <?php endif; ?>

                    <input type="hidden" name="Id_Rest" value="<?php echo isset($ultimoRestaurante['Id_Rest']) ? $ultimoRestaurante['Id_Rest'] : ''; ?>">

                    <div class="input-contenedor">
                        <i class="fa-solid fa-utensils"></i>
                        <input type="text" id="restaurant-name" name="Name-restaurant" value="<?php echo isset($ultimoRestaurante['Name']) ? htmlspecialchars($ultimoRestaurante['Name']) : ''; ?>" readonly>
                        <label for="restaurant-name">Nombre Restaurante</label>
                    </div>

                    <div class="input-contenedor">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" id="full-name" name="Name" required>
                        <label for="full-name">Nombre Completo</label>
                    </div>

                    <div class="input-contenedor">
                        <i class="fa-solid fa-phone"></i>
                        <input type="text" id="phone" name="Phone" required>
                        <label for="phone">Teléfono</label>
                    </div>

                    <div class="input-contenedor">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" id="email" name="Email" required>
                        <label for="email">Correo</label>
                    </div>

                    <div class="input-contenedor">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="password" name="Pass" required>
                        <label for="password">Contraseña</label>
                    </div>
                    
                    <button type="submit">Registrar</button>
                </form>
            </div>
        </div>
    </section>
    <script src="../javascript/script-nav.js"></script>
</body>
</html>