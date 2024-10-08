<?php
require '../db/auth.php';
checkLogin();

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
    <title>Restaurante y Cantidad Mesas</title>
    <script src="https://kit.fontawesome.com/a2dd6045c4.js" crossorigin="anonymous"></script> 
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles_signupRestaurant.css">
    <link rel="stylesheet" href="../css/style-nav.css">
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
    <section>
        <div class="form-container">
            <div class="form-section">
                <h1 id="form-title">Registrar Nuevo Restaurante</h1>
                <form id="combined-form" action="../routes/signupRestaurant_route.php" method="POST" enctype="multipart/form-data">
                    
                    <div class="input-contenedor">
                        <i class="fa-solid fa-utensils"></i> <!-- icono restaurant -->
                        <label for="name">Nombre del Restaurante:</label>
                        <input type="text" id="name" name="name" maxlength="100" required>
                    </div>

                    <div class="input-contenedor">
                        <i class="fa-solid fa-map-marker-alt"></i>
                        <label for="address">Dirección:</label>
                        <input type="text" id="address" name="address" maxlength="200" required>
                    </div>

                    <div class="input-contenedor">
                        <i class="fa-solid fa-phone"></i> <!-- icono phone -->
                        <label for="phone">Teléfono:</label>
                        <input type="text" id="phone" name="phone" oninput="validatePhone()" required>
                        <span id="phone-error" style="color: rgb(255, 255, 255); display: none;">Caracteres inválidos. Solo se permiten números y guiones.</span>
                    </div>

                    <div class="input-contenedor">
                        <i class="fa-solid fa-envelope"></i> <!-- icono email -->
                        <label for="email">Correo:</label>
                        <input type="text" id="email" name="email" maxlength="200" required>
                    </div>
                    
                    <label for="image">Subir Imagen (máximo 1):</label>
                    <input type="file" id="image" name="image" accept="image/*" onchange="previewImage()" required>

                    <div class="image-container">
                        <div class="image-preview" id="image-preview"></div>
                    </div>
                    
                <div class = "tables-container">
                    <h1 class="title-mesas">Cantidad de Mesas</h1>    
                    <div class="input-container-tables">
                        <label for="tables-2" class="label-tables">Mesas para 2 personas:</label>
                        <input type="number" id="tables-2" class="input-tables" name="tables_2" min="0" value="0" oninput="updateTotalTables()" required>
                    </div>
                    <div class="input-container-tables">
                        <label for="tables-4" class="label-tables">Mesas para 4 personas:</label>
                        <input type="number" id="tables-4" class="input-tables" name="tables_4" min="0" value="0" oninput="updateTotalTables()" required>
                    </div>
                    <div class="input-container-tables">
                        <label for="tables-6" class="label-tables">Mesas para 6 personas:</label>
                        <input type="number" id="tables-6" class="input-tables" name="tables_6" min="0" value="0" oninput="updateTotalTables()" required>
                    </div>
                    <div class="input-container-tables">
                        <label for="tables-10" class="label-tables">Mesas para 10 personas:</label>
                        <input type="number" id="tables-10" class="input-tables" name="tables_10" min="0" value="0" oninput="updateTotalTables()" required>
                    </div>
                    <div class="input-container-tables">
                        <label for="total-tables" class="label-tables">Cantidad de Mesas:</label>
                        <input type="text" id="total-tables" class="input-tables" name="total_tables" readonly>
                    </div>
                </div>
                    <div class="button-container-mesas">
                        <button type="submit" id="save-button">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </section>


    <script>
        function previewImage() {
            const preview = document.getElementById('image-preview');
            preview.innerHTML = ''; // Limpiar el contenido previo del contenedor

            const file = document.getElementById('image').files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('preview-image');
                preview.appendChild(img);
            }
            reader.readAsDataURL(file);
        }

        function validatePhone() {
            const phoneInput = document.getElementById('phone');
            const phoneError = document.getElementById('phone-error');
            const validCharacters = /^[0-9-]*$/;

            if (!validCharacters.test(phoneInput.value)) {
                phoneError.style.display = 'inline';
            } else {
                phoneError.style.display = 'none';
            }

            phoneInput.value = phoneInput.value.replace(/[^0-9-]/g, '');
        }

        function updateTotalTables() {
            const tables2 = parseInt(document.getElementById('tables-2').value) || 0;
            const tables4 = parseInt(document.getElementById('tables-4').value) || 0;
            const tables6 = parseInt(document.getElementById('tables-6').value) || 0;
            const tables10 = parseInt(document.getElementById('tables-10').value) || 0;

            const totalTables = tables2 + tables4 + tables6 + tables10;
            document.getElementById('total-tables').value = totalTables;
        }

        function switchToEditMode() {
            document.getElementById('form-title').textContent = "Editar Información del Restaurante";
            document.getElementById('save-button').textContent = "Guardar Cambios";
            document.getElementById('edit-button').style.display = 'none';
            document.getElementById('register-button').style.display = 'inline-block';
        }

        function switchToRegisterMode() {
            document.getElementById('form-title').textContent = "Registrar Nuevo Restaurante";
            document.getElementById('save-button').textContent = "Guardar";
            document.getElementById('edit-button').style.display = 'inline-block';
            document.getElementById('register-button').style.display = 'none';
            document.getElementById('combined-form').reset();
        }
    </script>
    <script src="../javascript/script-nav.js"></script>

</body>
</html>