<?php
require '../controllers/singupAdminRestaurant_controller.php';

$ultimoRestaurante = obtenerUltimoRestaurante();
$errorMensaje = "";
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
</body>
</html>