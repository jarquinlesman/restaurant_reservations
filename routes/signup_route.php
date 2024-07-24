<?php
require '../controllers/signup_controller.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Name']) && isset($_POST['Phone']) && isset($_POST['Email']) && isset($_POST['Pass'])) {
        $name = $_POST['Name'];
        $phone = $_POST['Phone'];
        $email = $_POST['Email'];
        $pass = $_POST['Pass'];

        if (insertClient($name, $phone, $email, $pass)) {
            echo "<script>alert('Registro exitoso.'); window.location='../index.php';</script>";
        } else {
            echo "<script>alert('Error al registrar. Por favor, inténtelo de nuevo.'); history.back();</script>";
        }
    } else {
        echo "<script>alert('Por favor complete todos los campos.'); history.back();</script>";
    }
}
?>
