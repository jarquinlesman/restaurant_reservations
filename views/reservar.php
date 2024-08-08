<?php
session_start();
// Obtener los datos del restaurante desde la URL
$id_rest = isset($_GET['id']) ? $_GET['id'] : '';
$name = isset($_GET['name']) ? $_GET['name'] : '';
$location = isset($_GET['location']) ? $_GET['location'] : '';
$phone = isset($_GET['phone']) ? $_GET['phone'] : '';
$email = isset($_GET['email']) ? $_GET['email'] : '';

// Obtener la imagen desde la sesión
$image = isset($_SESSION['restaurant_image_' . $id_rest]) ? $_SESSION['restaurant_image_' . $id_rest] : '';

// Obtener el nombre del usuario desde la sesión
$user_name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservación</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">

    <script>
        function validateForm() {
            const numeroPersonas = document.getElementById('numero_personas');
            const value = parseInt(numeroPersonas.value, 10);
            if (value < 1 || value > 10) {
                alert('El número de personas debe estar entre 1 y 10.');
                return false;
            }
            return true;
        }
    </script>
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
                    <li><a href="../views/restaurant.php" class="active"><i class="fas fa-home"></i> Inicio</a></li>
                    <li><a href="../views/historialReservas.php"><i class="fas fa-calendar-alt"></i> Reservaciones</a></li>
                </ul>
                <ul class="menu-right">
                    <li><a href=""><i class="fas fa-user"></i> Mi Perfil</a></li>
                    <li><a href="#" class="logout-btn">Salir</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="todo_reservar">
        <div class="contenedor_reservar"> 
            <div class="formulario">
                <form action="../routes/reservation_route.php" method="POST">
                    <h2>Reservación</h2>
                    <div class="input-contenedor">
                        <label for="nombre_cliente">Nombre del Cliente</label>
                        <input type="text" id="nombre_cliente" name="nombre_cliente" value="<?php echo htmlspecialchars($user_name); ?>" readonly>
                    </div>
                    <div class="campos_reservar">
                        <label for="fecha_reservacion">Fecha de Reservación</label>
                        <input type="date" id="fecha_reservacion" name="fecha_reservacion" required>
                    </div>
                    <div class="campos_reservar">
                        <label for="hora_reservacion">Hora de Reservación</label>
                        <input type="time" id="hora_reservacion" name="hora_reservacion" required>
                    </div>
                    <div class="input-contenedor">
                        <label for="numero_personas">Número de Personas</label>
                        <input type="number" id="numero_personas" name="numero_personas" min="1" max="10" required>
                    </div>
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                    <input type="hidden" name="id_rest" value="<?php echo htmlspecialchars($id_rest); ?>">
                    <div>
                        <button type="submit">Reservar</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Formulario #2 (detalles del restaurante)-->
        <div class="contenedor_reservar2"> 
            <div class="formulario">
                <form action="#">
                    <div class="campos_reservar2">
                        <div class="encabezado">
                         <h3><?php echo htmlspecialchars($name); ?></h3>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <img src="data:image/jpeg;base64,<?php echo htmlspecialchars($image); ?>" alt="restaurante">
                    </div>
                    <div class="campos_reservar2">
                        <div class="encabezado">
                            <h3>Detalles adicionales</h3>
                        </div>

                        <div class="info">
                            <p><b>Dirección:</b> <?php echo htmlspecialchars($location); ?></p>
                            <p><b>Teléfono:</b> <?php echo htmlspecialchars($phone); ?></p>
                            <p><b>Email:</b> <?php echo htmlspecialchars($email); ?></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script src="../javascript/script-nav.js"></script>
</body>
</html>