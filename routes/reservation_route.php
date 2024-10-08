<?php
require '../controllers/reservation_controller.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['user_id']) && isset($_POST['id_rest']) && isset($_POST['fecha_reservacion']) && isset($_POST['hora_reservacion']) && isset($_POST['numero_personas'])) {
        $id_user = $_POST['user_id'];
        $id_rest = $_POST['id_rest'];
        $date = $_POST['fecha_reservacion'];
        $start_time = $_POST['hora_reservacion'];
        $people = $_POST['numero_personas'];

        // Calcular end_time
        $date_time = new DateTime($start_time);
        $date_time->add(new DateInterval('PT2H'));
        $end_time = $date_time->format('H:i');

        // Llamar a la función para insertar la reserva
        $result = insertReservation($id_user, $id_rest, $date, $start_time, $end_time, $people);

        // Mostrar el mensaje de acuerdo al resultado
        if ($result === true) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Reservación Exitosa',
                        text: 'Su reservación fue guardada con éxito. Por favor, esté pendiente de su correo para confirmar su reservación.',
                        timer: 3000,
                        timerProgressBar: true
                    }).then(() => {
                        window.location.href = '../views/historialReservas.php';
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
                        text: '".$result."',
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
                    text: 'Por favor complete todos los campos.',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    history.back();
                });
            });
        </script>";
    }
}
?>