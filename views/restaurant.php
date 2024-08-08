<?php
require '../db/auth.php';
checkLogin();

require_once '../routes/restaurant_route.php'; // Incluye la ruta que a su vez incluye el controlador

$restaurantsData = getRestaurants(); // Llama a la función del controlador
$restaurants = $restaurantsData['restaurants'];
$error = $restaurantsData['error'];

$showRegisterRestaurant = false;
if (isset($_SESSION['showRegisterRestaurant']) && $_SESSION['showRegisterRestaurant'] === true) {
    $showRegisterRestaurant = true; // Cambiar a verdadero si es el super administrador
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuestros Restaurantes</title>
    <script src="https://kit.fontawesome.com/a2dd6045c4.js" crossorigin="anonymous"></script> 
    <link rel="stylesheet" href="../css/style-restaurant.css">
    <link rel="stylesheet" href="../css/style-nav.css">
    <script>
        function showError(error) {
            if (error) {
                alert(error);
            }
        }
    </script>
</head>
<body onload="showError('<?php echo htmlspecialchars($error); ?>')">
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
                    <li><a href="../views/restaurant.php" class="active"><i class="fas fa-home"></i>Inicio</a></li>
                    <?php if (!$showRegisterRestaurant): ?>
                        <li><a href="../views/historialReservas.php"><i class="fas fa-calendar-alt"></i>Reservaciones</a></li>
                    <?php endif; ?>
                        <?php if ($showRegisterRestaurant): ?>
                            <li><a href="../views/signup_restaurant.php"><i class="fa-solid fa-circle-plus"></i>Registrar Restaurante</a></li>
                        <?php endif; ?>
                </ul>
                <ul class="menu-right">
                    <li><a href="../views/mi_perfil.php"><i class="fas fa-user"></i> Mi Perfil</a></li>
                    <li><a href="../db/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Salir</a></li>
            </ul>
            </nav>
        </div>
    </header>
    <!-- <script>
        document.addEventListener('DOMContentLoaded', function () {
            const menuItems = document.querySelectorAll('.menu li a, .menu-right li a');

            menuItems.forEach(item => {
                item.addEventListener('click', function () {
                    // Eliminar la clase 'active' de todos los elementos
                    menuItems.forEach(i => i.classList.remove('active'));

                    // Añadir la clase 'active' al elemento clicado
                    this.classList.add('active');
                });
            });
        });
    </script> -->

    <div class="container">
        <h1>Nuestros Restaurantes</h1>
        <div class="restaurant-list">
            <?php if (empty($restaurants)): ?>
                <p>No se encontraron restaurantes disponibles.</p>
            <?php else: ?>
                <?php foreach ($restaurants as $restaurant): ?>
                    <?php
                    // Guardar la imagen en la sesión
                    $_SESSION['restaurant_image_' . $restaurant['Id_Rest']] = $restaurant['Image'];
                    ?>
                    <div class="restaurant-card">
                        <img src="data:image/jpeg;base64,<?php echo htmlspecialchars($restaurant['Image']); ?>" alt="Restaurante">
                        <div class="restaurant-info">
                            <h2><?php echo htmlspecialchars($restaurant['Name']); ?></h2>
                            <p>Dirección: <?php echo htmlspecialchars($restaurant['Location']); ?></p>
                            <p>Teléfono: <?php echo htmlspecialchars($restaurant['Phone']); ?></p>
                            <p>Email: <?php echo htmlspecialchars($restaurant['Email']); ?></p>
                            
                            <?php if ($showRegisterRestaurant): ?>
                                <!-- Botón Editar para super administrador -->
                                <form action="editarRestaurant.php" method="GET">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($restaurant['Id_Rest']); ?>">
                                    <button type="submit">Editar</button>
                                </form>
                            <?php else: ?>
                                <!-- Botón Reservar para otros usuarios -->
                                <form action="reservar.php" method="GET">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($restaurant['Id_Rest']); ?>">
                                    <input type="hidden" name="name" value="<?php echo htmlspecialchars($restaurant['Name']); ?>">
                                    <input type="hidden" name="location" value="<?php echo htmlspecialchars($restaurant['Location']); ?>">
                                    <input type="hidden" name="phone" value="<?php echo htmlspecialchars($restaurant['Phone']); ?>">
                                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($restaurant['Email']); ?>">
                                    <button type="submit">Reservar</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <script src="../javascript/script-nav.js"></script>
</body>
</html>