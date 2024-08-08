<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://kit.fontawesome.com/a2dd6045c4.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="../css/style-recovery.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <section>
        <div class="contenedor-recu">
            <div class="formulario-recu">
                <form action="../db/recovery_password.php" method="POST" onsubmit="return validarFormulario()">
                    <h2>Recuperar Contraseña</h2>
                    <div class="input-contenedor-recu">
                        <i class="fa-solid fa-envelope"></i> <!-- icono email -->
                        <input type="email" id="email" name="Email" required>
                        <label for="email">Correo</label>
                    </div>
                    <button type="submit">Enviar</button>
                </form>
                <div class="volver-recu">
                    <p>Regresar a
                        <a href="../index.php">Iniciar Sesión</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Script para validar formulario y manejar mensajes -->
        <script>
            function validarFormulario() {
                var email = document.getElementById('email').value.trim();

                if (email === '') {
                    mostrarAlerta('Por favor complete el campo de correo.');
                    return false;
                }

                return true;
            }
        </script>
    </section>
</body>
</html>
