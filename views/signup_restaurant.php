<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurante y Cantidad Mesas</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles_signupRestaurant.css">
</head>
<body>
    <div class="wrapper">
        <div class="form-container">
            <div class="form-section">
                <h1 id="form-title">Registrar Nuevo Restaurante</h1>
                <form id="combined-form" action="combined_process.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="restaurant_id" name="restaurant_id" value="">

                    <label for="name">Nombre del Restaurante:</label>
                    <input type="text" id="name" name="name" maxlength="100">

                    <label for="address">Dirección:</label>
                    <input type="text" id="address" name="address" maxlength="200">

                    <label for="phone">Teléfono:</label>
                    <input type="text" id="phone" name="phone" oninput="validatePhone()">
                    <span id="phone-error" style="color: rgb(255, 255, 255); display: none;">Caracteres inválidos. Solo se permiten números y guiones.</span>

                    <label for="image">Subir Imagen (máximo 1):</label>
                    <input type="file" id="image" name="image" accept="image/*" onchange="previewImage()">

                    <div class="image-container">
                        <div class="image-preview" id="image-preview"></div>
                    </div>
                </form>
            </div>

            <div class="form-section form-section-mesas">
                <h1 class="title-mesas">Cantidad de Mesas</h1>
                <form id="tables-form" action="tables_process.php" method="POST">
                    <div class="input-container-tables">
                        <label for="tables-2" class="label-tables">Mesas para 2 personas:</label>
                        <input type="number" id="tables-2" class="input-tables" name="tables_2" min="0" value="0" oninput="updateTotalTables()">
                    </div>
                    <div class="input-container-tables">
                        <label for="tables-4" class="label-tables">Mesas para 4 personas:</label>
                        <input type="number" id="tables-4" class="input-tables" name="tables_4" min="0" value="0" oninput="updateTotalTables()">
                    </div>
                    <div class="input-container-tables">
                        <label for="tables-6" class="label-tables">Mesas para 6 personas:</label>
                        <input type="number" id="tables-6" class="input-tables" name="tables_6" min="0" value="0" oninput="updateTotalTables()">
                    </div>
                    <div class="input-container-tables">
                        <label for="tables-10" class="label-tables">Mesas para 10 personas:</label>
                        <input type="number" id="tables-10" class="input-tables" name="tables_10" min="0" value="0" oninput="updateTotalTables()">
                    </div>
                    <div class="input-container-tables">
                        <label for="total-tables" class="label-tables">Cantidad de Mesas:</label>
                        <input type="text" id="total-tables" class="input-tables" name="total_tables" readonly>
                    </div>

                    <div class="button-container-mesas">
                        <button type="button" id="edit-button" onclick="switchToEditMode()">Editar</button>
                        <button type="button" id="register-button" onclick="switchToRegisterMode()">Registrar</button>
                        <button type="submit" id="save-button">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
</body>
</html>
