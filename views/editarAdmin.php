<?php
require '../controllers/updateRestaurant_controller.php';

// Asegúrate de que estás recibiendo el Id_Rest como parámetro
$idRestaurante = $_GET['Id_Rest'] ?? null;

if (!$idRestaurante) {
    echo "<script>alert('ID de restaurante no válido.'); window.location.href = '../views/restaurant.php';</script>";
    exit;
}

// Obtener los datos del administrador
$adminDetails = getAdminDetails($idRestaurante);
$errorMensaje = "";

// Verificar si se encontraron detalles del administrador
if (!$adminDetails) {
    echo "<script>alert('No se encontró información del administrador.'); window.location.href = '../views/restaurant.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://kit.fontawesome.com/a2dd6045c4.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>Editar Administrador</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <section class="todo_reg">
        <div class="contenedor_reg"> 
            <div class="formulario">
                <form action="../routes/updateAdmin_route.php" method="POST">
                    <h2>Administrador</h2>
                    <?php if (!empty($errorMensaje)): ?>
                        <div class="error-message" style="color: red;">
                            <?php echo htmlspecialchars($errorMensaje); ?>
                        </div>
                    <?php endif; ?>

                    <input type="hidden" name="Id_Admin" value="<?php echo htmlspecialchars($adminDetails['Id_User']); ?>">

                    <div class="input-contenedor">
                        <i class="fa-solid fa-utensils"></i>
                        <input type="text" id="restaurant-name" name="Name-restaurant" value="<?php echo htmlspecialchars($adminDetails['RestaurantName']); ?>" readonly>
                        <label for="restaurant-name">Nombre Restaurante</label>
                    </div>

                    <div class="input-contenedor">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" id="full-name" name="Name" value="<?php echo htmlspecialchars($adminDetails['Name']); ?>" required>
                        <label for="full-name">Nombre Completo</label>
                    </div>

                    <div class="input-contenedor">
                        <i class="fa-solid fa-phone"></i>
                        <input type="text" id="phone" name="Phone" oninput="validatePhone()" value="<?php echo htmlspecialchars($adminDetails['Phone']); ?>" required>
                        <label for="phone">Teléfono</label>
                    </div>

                    <div class="input-contenedor">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" id="email" name="Email" value="<?php echo htmlspecialchars($adminDetails['Email']); ?>" required>
                        <label for="email">Correo</label>
                    </div>

                    <div class="input-contenedor">
                        <i class="fa-solid fa-key"></i>
                        <input type="text" id="password" name="Pass" value="<?php echo htmlspecialchars($adminDetails['Pass']); ?>" required>
                        <label for="password">Contraseña</label>
                    </div>

                    <button type="submit">Actualizar Administrador</button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>
