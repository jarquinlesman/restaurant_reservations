<?php
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cierre de sesión</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: '¡Cierre de sesión exitoso!',
                text: 'Has cerrado sesión correctamente.',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                window.location.href = '../index.php';
            });
        });
    </script>
</body>
</html>