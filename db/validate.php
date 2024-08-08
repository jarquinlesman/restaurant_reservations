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
                    header("Location: ../views/restaurant.php"); // Redirigir al Super Administrador
                } elseif ($user['Id_Role'] == 2) {
                    $_SESSION['showRegisterRestaurant'] = false; // Para el Administrador
                    header("Location: ../views/signup_restaurant.php"); // Redirigir al Administrador
                } elseif ($user['Id_Role'] == 3) {
                    $_SESSION['showRegisterRestaurant'] = false; // Para el Usuario normal
                    header("Location: ../views/restaurant.php"); // Redirigir al Usuario normal
                } else {
                    echo "<script>alert('Rol de usuario no válido.'); history.back();</script>";
                    exit();
                }
                
            } else {
                echo "<script>alert('Contraseña inválida.'); history.back();</script>";
                exit();
            }
        } else {
            echo "<script>alert('No se encontró ningún usuario con ese correo.'); history.back();</script>";
            exit();
        }
    } else {
        echo "<script>alert('Por favor complete todos los campos.'); history.back();</script>";
        exit();
    }
}
?>