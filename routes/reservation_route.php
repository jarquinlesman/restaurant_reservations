<?php 
require '../controllers/reservation_controller.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['user_id']) && isset($_POST['id_rest']) && isset($_POST['fecha_reservacion']) && isset($_POST['hora_reservacion']) && isset($_POST['numero_personas'])) {
        $id_user = $_POST['user_id'];
        $id_rest = $_POST['id_rest'];
        $date = $_POST['fecha_reservacion'];
        $start_time = $_POST['hora_reservacion'];
        $people = $_POST['numero_personas'];
        
        $date_time = new DateTime($start_time);
        $date_time->add(new DateInterval('PT2H'));
        $end_time = $date_time->format('H:i');

        $result = insertReservation($id_user, $id_rest, $date, $start_time, $end_time, $people);

        if ($result === true) {
            echo "<script>alert('Su reservación fue guardada con éxito, por favor, estar pendiente de su correo para confirmar su reservación.'); window.location='../index.php';</script>";
        } else {
            echo "<script>alert('".$result."'); history.back();</script>";
        }
        
    } else {
        echo "<script>alert('Por favor complete todos los campos.'); history.back();</script>";
    }

}
?>