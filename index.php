<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Redireccionamiento para usar el codigo de los iconos -->
    <script src="https://kit.fontawesome.com/a2dd6045c4.js" crossorigin="anonymous"></script> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">

    <!-- Script para manejar mensajes emergentes -->
    <script>
        function mostrarAlerta(mensaje) {
            alert(mensaje);
        }
    </script>

</head>
<body>
    <section>
        <div class="contenedor">
            <div class="formulario">
                <form action="db/validate.php" method="POST" onsubmit="return validarFormulario()">
                    <h2>Iniciar Sesión</h2>
                    <div class="input-contenedor">
                        <i class="fa-solid fa-envelope"></i> <!-- icono email -->
                        <input type="email" id="email" name="Email" required>
                        <label for="email">Correo</label>
                    </div>

                    <div class="input-contenedor">
                        <i class="fa-solid fa-lock"></i> <!-- icono candado -->
                        <input type="password" id="pass" name="Pass" required>
                        <label for="pass">Contraseña</label>
                    </div>

                    <div class="olvidar">
                        <label for="#">
                            <input type="checkbox"> Recordatorio 
                            <a href="#">¿Olvidó su contraseña?</a>
                        </label>
                    </div>
                    
                    <button type="submit">Acceder</button>
                </form>
                <div class="registrar">
                    <p>No tengo cuenta
                        <a href="views/signup.php">Crear una cuenta</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Script para validar formulario y manejar mensajes -->
        <script>
            function validarFormulario() {
                var email = document.getElementById('email').value.trim();
                var pass = document.getElementById('pass').value.trim();

                if (email === '' || pass === '') {
                    mostrarAlerta('Por favor complete todos los campos.');
                    return false;
                }

                return true;
            }
        </script>
        
    </section>
</body>
</html>