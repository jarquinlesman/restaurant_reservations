<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica que las variables estén definidas
    if (isset($_POST['Email']) && isset($_POST['Pass'])) {
        $email = $_POST['Email'];
        $pass = $_POST['Pass'];

        // Consulta a la base de datos para obtener el usuario
        $query = "SELECT * FROM `users` WHERE Email = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Verificación de la contraseña
            if (isset($user['Pass']) && $pass == $user['Pass']) {
                $_SESSION['user_id'] = $user['Id_User'];
                $_SESSION['email'] = $user['Email'];
                $_SESSION['name'] = $user['Name'];
                $_SESSION['phone'] = $user['Phone'];
                $_SESSION['pass'] = $user['Pass'];
                $_SESSION['role'] = $user['Id_Role'];

                // Validación del rol del usuario
                if ($user['Id_Role'] == 1) {
                    $_SESSION['showRegisterRestaurant'] = true; // Para el Super Administrador
                    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Inicio de sesión exitoso',
                                text: 'Redirigiendo al panel del Super Administrador...',
                                timer: 2000,
                                timerProgressBar: true
                            }).then(() => {
                                window.location.href = '../views/restaurant.php';
                            });
                        });
                    </script>";
                } elseif ($user['Id_Role'] == 2) {
                    $_SESSION['showRegisterRestaurant'] = false; // Para el Administrador
                    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Inicio de sesión exitoso',
                                text: 'Redirigiendo a la página de Reservas...',
                                timer: 2000,
                                timerProgressBar: true
                            }).then(() => {
                                window.location.href = '../views/reservasAdmin.php';
                            });
                        });
                    </script>";
                } elseif ($user['Id_Role'] == 3) {
                    $_SESSION['showRegisterRestaurant'] = false; // Para el Usuario normal
                    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Inicio de sesión exitoso',
                                text: 'Redirigiendo a la página principal...',
                                timer: 2000,
                                timerProgressBar: true
                            }).then(() => {
                                window.location.href = '../views/restaurant.php';
                            });
                        });
                    </script>";
                } else {
                    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Rol de usuario no válido',
                                text: 'Por favor, contacta al administrador.',
                                confirmButtonText: 'Aceptar'
                            }).then(() => {
                                history.back();
                            });
                        });
                    </script>";
                    exit();
                }
                
            } else {
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Contraseña inválida',
                            text: 'La contraseña que has ingresado es incorrecta.',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            history.back();
                        });
                    });
                </script>";
                exit();
            }
        } else {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Correo no encontrado',
                        text: 'No se encontró ningún usuario con ese correo electrónico.',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        history.back();
                    });
                });
            </script>";
            exit();
        }
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos incompletos',
                    text: 'Por favor complete todos los campos.',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    history.back();
                });
            });
        </script>";
        exit();
    }
}
?>