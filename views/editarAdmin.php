<?php
require '../db/auth.php';
checkLogin();

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

// Obtener todos los administradores del restaurante
$admins = getAllAdmins($idRestaurante);

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
    <script>
    function loadAdminDetails() {
        const select = document.getElementById('admin-select');
        const idAdmin = select.value;

        fetch('../routes/getAdminInfo_route.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'Id_Admin=' + idAdmin
        })
        .then(response => response.json())
        .then(data => {
            if (!data.error) {
                document.getElementById('phone').value = data.Phone;
                document.getElementById('email').value = data.Email;
                document.getElementById('password').value = data.Pass;
            } else {
                alert(data.error);
            }
        });
    }

    function clearFields() {
        document.getElementById('phone').value = '';
        document.getElementById('email').value = '';
        document.getElementById('password').value = '';
        document.getElementById('admin-select').value = ''; // Limpiar el combobox
    }

    function toggleButtons(isAdding) {
        const updateButton = document.getElementById('update-admin');
        const addButton = document.getElementById('add-admin');
        const registerButton = document.getElementById('register');
        const backButton = document.getElementById('back');

        const selectContainer = document.getElementById('select-container');
        const nameInputContainer = document.getElementById('name-input-container');

        if (isAdding) {
            updateButton.style.display = 'none';
            addButton.style.display = 'none';
            registerButton.style.display = 'block';
            backButton.style.display = 'block';

            selectContainer.style.display = 'none'; // Ocultar el combobox
            nameInputContainer.style.display = 'block'; // Mostrar el input de Nombre Completo
            clearFields(); // Limpiar campos de Teléfono, Correo Electrónico y Contraseña
        } else {
            updateButton.style.display = 'block';
            addButton.style.display = 'block';
            registerButton.style.display = 'none';
            backButton.style.display = 'none';

            selectContainer.style.display = 'block'; // Mostrar el combobox
            nameInputContainer.style.display = 'none'; // Ocultar el input de Nombre Completo
            clearFields(); // Limpiar campos de Teléfono, Correo Electrónico y Contraseña al volver
        }
    }

    window.onload = function() {
        toggleButtons(false); // Asegurarse de que los botones y campos se configuren correctamente al cargar
    };
</script>

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

                    <input type="hidden" name="Id_Admin" id="id-admin" value="<?php echo htmlspecialchars($adminDetails['Id_User']); ?>">

                    <div class="input-contenedor">
                        <i class="fa-solid fa-utensils"></i>
                        <input type="text" id="restaurant-name" name="Name-restaurant" value="<?php echo htmlspecialchars($adminDetails['RestaurantName']); ?>" readonly>
                        <label for="restaurant-name">Nombre Restaurante</label>
                    </div>

                    <div id="select-container" class="input-contenedor">
                        <i class="fa-solid fa-user"></i>
                        <label for="admin-select">Seleccionar Administrador</label>
                        <select id="admin-select" name="admin-select" onchange="loadAdminDetails()" class="transparent-select">
                            <option value="">Selecciona...</option>
                            <?php foreach ($admins as $admin): ?>
                                <option value="<?php echo htmlspecialchars($admin['Id_User']); ?>"><?php echo htmlspecialchars($admin['Name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div id="name-input-container" class="input-contenedor" style="display: none;">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" id="name" name="Name" required>
                        <label for="name">Nombre Completo</label>
                    </div>

                    <div class="input-contenedor">
                        <i class="fa-solid fa-phone"></i>
                        <input type="text" id="phone" name="Phone" required>
                        <label for="phone">Teléfono</label>
                    </div>

                    <div class="input-contenedor">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" id="email" name="Email" required>
                        <label for="email">Correo Electrónico</label>
                    </div>

                    <div class="input-contenedor">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="password" name="Pass" required>
                        <label for="password">Contraseña</label>
                    </div>

                    <div class="button-contenedor">
                        <button type="button" id="add-admin" onclick="toggleButtons(true)">Registrar Nuevo Administrador</button>
                        <button type="submit" id="update-admin" style="display: none;">Actualizar Administrador</button>
                        <button type="submit" id="register" style="display: none;" formaction="../routes/registerAdmin_route.php">Registrar</button>
                        <button type="button" id="back" style="display: none;" onclick="toggleButtons(false)">Volver</button>
                        <button type="submit" id="update-admin" style="display: none;" formaction="../routes/updateAdmin_route.php">Actualizar Administrador</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>
</html>
