<?php
require '../db/auth.php';
checkLogin();
// Incluye el controlador que maneja la lógica de validación y actualización
$data = require_once '../controllers/validacionEditar_controller.php';

$restaurantData = $data['restaurantData'];
$tablesData = $data['tablesData'];
$showRegisterRestaurant = $data['showRegisterRestaurant'];
$error = $data['error'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style-nav.css">
    <link rel="stylesheet" href="../css/styles_signupRestaurant.css">
    <title>Restaurante y Cantidad Mesas</title>
    <script src="https://kit.fontawesome.com/a2dd6045c4.js" crossorigin="anonymous"></script> 
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <!-- Navegación -->
    <header class="header">
        <div class="container-navbar">
            <nav class="navbar">
                <ul class="menu">
                <li><a href="../views/restaurant.php"><i class="fas fa-home"></i>Inicio</a></li>
                    <?php if ($showRegisterRestaurant): ?>
                        <li><a href="../views/signup_restaurant.php"><i class="fa-solid fa-circle-plus"></i>Registrar Restaurante</a></li>
                        <li><a href="../views/editarRestaurant.php" class="active"><i class="fa-solid fa-pen-to-square"></i>Editar Restaurante</a></li>
                    <?php endif; ?>
                </ul>
                <ul class="menu-right">
                    <li><a href="../views/mi_perfil.php"><i class="fas fa-user"></i> Mi Perfil</a></li>
                    <li><a href="../db/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Salir</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section>

    <div class="form-container">
        <div class="form-section">
            <h1 id="form-title">Editar Restaurante</h1>
            <form id="combined-form" action="../routes/updateRestaurant_route.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $restaurantData['Id_Rest']; ?>">

                <div class="input-contenedor">
                    <i class="fa-solid fa-utensils"></i>
                    <label for="name">Nombre del Restaurante:</label>
                    <input type="text" id="name" name="name" maxlength="100" value="<?php echo htmlspecialchars($restaurantData['Name']); ?>" required>
                </div>
                
                <div class="input-contenedor">
                    <i class="fa-solid fa-map-marker-alt"></i>
                    <label for="address">Dirección:</label>
                    <input type="text" id="address" name="address" maxlength="200" value="<?php echo htmlspecialchars($restaurantData['Location']); ?>" required>
                </div>
                
                <div class="input-contenedor">
                    <i class="fa-solid fa-phone"></i>
                    <label for="phone">Teléfono:</label>
                    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($restaurantData['Phone']); ?>" required>
                </div>
                
                <div class="input-contenedor">
                    <i class="fa-solid fa-envelope"></i>
                    <label for="email">Correo:</label>
                    <input type="text" id="email" name="email" maxlength="200" value="<?php echo htmlspecialchars($restaurantData['Email']); ?>" required>
                </div>
                
                <label for="image">Subir Imagen (máximo 1):</label>
                <input type="file" id="image" name="image" accept="image/*" onchange="previewImage()">
                
                <div class="image-container">
                    <div class="image-preview" id="image-preview"></div>
                </div>

                <div class="tables-container">
                    <h1 class="title-mesas">Cantidad de Mesas</h1>
                    <div class="input-container-tables">
                        <label for="tables-2" class="label-tables">Mesas para 2 personas:</label>
                        <input type="number" id="tables-2" class="input-tables" name="tables_2" min="0" value="<?php echo htmlspecialchars($tablesData[1] ?? 0); ?>" required oninput="updateTotalTables()">
                    </div>
                    <div class="input-container-tables">
                        <label for="tables-4" class="label-tables">Mesas para 4 personas:</label>
                        <input type="number" id="tables-4" class="input-tables" name="tables_4" min="0" value="<?php echo htmlspecialchars($tablesData[2] ?? 0); ?>" required oninput="updateTotalTables()">
                    </div>
                    <div class="input-container-tables">
                        <label for="tables-6" class="label-tables">Mesas para 6 personas:</label>
                        <input type="number" id="tables-6" class="input-tables" name="tables_6" min="0" value="<?php echo htmlspecialchars($tablesData[3] ?? 0); ?>" required oninput="updateTotalTables()">
                    </div>
                    <div class="input-container-tables">
                        <label for="tables-10" class="label-tables">Mesas para 10 personas:</label>
                        <input type="number" id="tables-10" class="input-tables" name="tables_10" min="0" value="<?php echo htmlspecialchars($tablesData[4] ?? 0); ?>" required oninput="updateTotalTables()">
                    </div>
                    <div class="input-container-tables">
                        <label for="total-tables" class="label-tables">Cantidad de Mesas:</label>
                        <input type="text" id="total-tables" class="input-tables" name="total_tables" readonly>
                    </div>
                </div>

                <div class="button-container-mesas">
                    <button type="submit" id="save-button">Editar</button>
                </div>
            </form>
        </div>
    </div>
    </section>

    <script>
        // Llama a la función para actualizar el total al cargar la página
        window.onload = function() {
            updateTotalTables();
        };
    </script>
    <script src="../javascript/signup_restaurant.js"></script>
    <script src="../javascript/script-nav.js"></script>

</body>
</html>