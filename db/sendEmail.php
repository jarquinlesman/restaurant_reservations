<?php

require '../db/db.php'; // Ajusta la ruta si es necesario

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Ajusta la ruta según tu estructura de directorios

function sendEmail($email, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'yourreservations1@gmail.com';
        $mail->Password   = 'iclk qomu vkbj gppe'; // Cambia esto por tu contraseña de correo
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Remitente y destinatario
        $mail->setFrom('yourreservations1@gmail.com', 'Reservaciones');
        $mail->addAddress($email);

        // Contenido del correo
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body    = $body;   

        // Enviar el correo
        $mail->send();
        
        return true;

    } catch (Exception $e) {
        error_log("Error al enviar el correo: " . $mail->ErrorInfo);
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Email'])) {
                
        $email = $_POST['Email'];
        
        // Consulta a la base de datos para obtener el usuario
        $query = "SELECT * FROM `users` WHERE Email = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $subject = "Estado de tu reservación";
            $body = "Tu reservación ha sido actualizada.";

            if (sendEmail($email, $subject, $body)) {
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                      <script>
                          document.addEventListener('DOMContentLoaded', function() {
                              Swal.fire({
                                  icon: 'success',
                                  title: 'Éxito',
                                  text: 'Se envió el correo con la notificación al cliente.',
                                  confirmButtonText: 'Aceptar'
                              }).then(() => {
                                  window.location.href = '../index.php';
                              });
                          });
                      </script>";
            } else {
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                      <script>
                          document.addEventListener('DOMContentLoaded', function() {
                              Swal.fire({
                                  icon: 'error',
                                  title: '¡Error!',
                                  text: 'No se pudo enviar el correo.',
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
                              icon: 'error',
                              title: '¡Error!',
                              text: 'Correo inválido o no encontrado.',
                              confirmButtonText: 'Aceptar'
                          }).then(() => {
                              history.back();
                          });
                      });
                  </script>";
        }
    } 
}
?>
