<?php
session_start();
require '../db/db.php'; // Ajusta la ruta si es necesario

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Ajusta la ruta según tu estructura de directorios

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica que la variable 'Email' esté definida
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
            $pass = $user['Pass']; // Obtén la contraseña del usuario

            // Configuración del servidor SMTP
            $mail = new PHPMailer(true);
            try {
                // Configuración del servidor SMTP
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com'; // Cambia esto por tu servidor SMTP
                $mail->SMTPAuth   = true;
                $mail->Username   = 'yourreservations1@gmail.com'; // Cambia esto por tu correo electrónico
                $mail->Password   = 'iclk qomu vkbj gppe'; // Cambia esto por tu contraseña de correo
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // O PHPMailer::ENCRYPTION_SMTPS para SSL
                $mail->Port       = 587; // Usa 465 para SSL

                // Remitente y destinatario
                $mail->setFrom('yourreservations1@gmail.com', 'Reservaciones');
                $mail->addAddress($email);

                // Contenido del correo
                $mail->isHTML(false); // Texto plano
                $mail->Subject = 'Recuperación de Contraseña';
                $mail->Body    = "Hemos recibido una solicitud para recuperar tu contraseña. Aquí está tu contraseña:\n\n" . $pass;

                // Enviar el correo
                $mail->send();
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                      <script>
                          document.addEventListener('DOMContentLoaded', function() {
                              Swal.fire({
                                  icon: 'success',
                                  title: 'Éxito',
                                  text: 'Hemos enviado tu contraseña al correo.',
                                  confirmButtonText: 'Aceptar'
                              }).then(() => {
                                  window.location.href = '../index.php';
                              });
                          });
                      </script>";
            } catch (Exception $e) {
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                      <script>
                          document.addEventListener('DOMContentLoaded', function() {
                              Swal.fire({
                                  icon: 'error',
                                  title: '¡Error!',
                                  text: 'No se pudo enviar el correo. Error: " . addslashes($mail->ErrorInfo) . "',
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
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
              <script>
                  document.addEventListener('DOMContentLoaded', function() {
                      Swal.fire({
                          icon: 'error',
                          title: '¡Error!',
                          text: 'Por favor complete el campo de correo.',
                          confirmButtonText: 'Aceptar'
                      }).then(() => {
                          history.back();
                      });
                  });
              </script>";
    }
}
?>