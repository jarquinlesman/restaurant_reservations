<?php
session_start();
require '../controllers/profile_controller.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Id_User']) && isset($_POST['Name']) && isset($_POST['Phone']) && isset($_POST['Email']) && isset($_POST['Pass'])) {
        $id = $_POST['Id_User'];
        $name = $_POST['Name'];
        $phone = $_POST['Phone'];
        $email = $_POST['Email'];
        $pass = $_POST['Pass'];

        // Actualiza la sesión con los nuevos datos
        $_SESSION['name'] = $name;
        $_SESSION['phone'] = $phone;
        $_SESSION['email'] = $email;
        $_SESSION['pass'] = $pass;

        if (updateClient($name, $phone, $email, $pass, $id)) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Actualización Exitosa',
                        text: 'Sus datos han sido actualizados correctamente.',
                        timer: 3000,
                        timerProgressBar: true
                    }).then(() => {
                        window.location.href = '../views/mi_perfil.php';
                    });
                });
            </script>";
        } else {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al actualizar. Por favor, inténtelo de nuevo.',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        history.back();
                    });
                });
            </script>";
        }
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos Incompletos',
                    text: 'Faltan datos. Por favor, complete todos los campos.',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    history.back();
                });
            });
        </script>";
    }
}
?>