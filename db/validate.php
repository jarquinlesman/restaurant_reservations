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
                header("Location: ../views/restaurant.php"); // Cambia la ubicación según sea necesario
                exit();
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