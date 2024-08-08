<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Redireccionamiento para usar el codigo de los iconos -->
    <script src="https://kit.fontawesome.com/a2dd6045c4.js" crossorigin="anonymous"></script> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Login</title>
</head>
<body>
    <section class="todo_reg">
        <div class="contenedor_reg"> 
            <div class="formulario">
                <form action="../routes/signup_route.php" method="POST">
                    <h2>Regístrate</h2>
                    <div class="input-contenedor">
                        <i class="fa-solid fa-user"></i> <!-- icono email -->
                        <input type="text" id="name" name="Name" required>
                        <label for="name">Nombre Completo</label>
                    </div>

                    <!-- código que coloque como prueba -->
                    <div class="input-contenedor">
                        <i class="fa-solid fa-phone"></i> <!-- icono email -->
                        <input type="text" id="phone" name="Phone" required>
                        <label for="phone">Teléfono</label>
                    </div>
                    <!-- código que coloque como prueba -->

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
                            <input type="checkbox"> Aceptar términos y condiciones 
                        </label>
                    </div>
                    
                    <button type="submit">Registrarse</button>
                </form>
                <div>
                    <div class="registrar">
                        <p>
                            <a href="../index.php">Tengo una cuenta
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>