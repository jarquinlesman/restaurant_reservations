<?php
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

require_once '../db/db.php';
require_once '../db/sendEmail.php';

class reservasAdmin_controller{

    public function estado($id_res, $state){
    global $conexion;

    $response = array();    
    
    try{

        $sql = "UPDATE reservation SET State = ? WHERE Id_Reservation = ?"; 
        $stmt = $conexion->prepare($sql);
        $result = $stmt->execute([$state, $id_res]);

        if($result){
            $response['success'] = true;

            // Obtener la información del usuario para enviar el correo
            $sql_user = "SELECT u.Email, res.Name , r.ReservationDate, r.StartTime, r.EndTime
            FROM reservation r
            JOIN users u ON r.Id_User = u.Id_User
            JOIN restaurant res ON r.Id_Rest = res.Id_Rest
            WHERE r.Id_Reservation = ?;";
           
           $stmt_user = $conexion->prepare($sql_user);
           $stmt_user->bind_param("i", $id_res);
           $stmt_user->execute();
           $result_user = $stmt_user->get_result();

           if ($result_user->num_rows > 0) {
           $reservation_data = $result_user->fetch_assoc();
           $email = $reservation_data['Email'];
           $restaurant = $reservation_data['Name'];
           $date = $reservation_data['ReservationDate'];
           $start_time = $reservation_data['StartTime'];
           $end_time = $reservation_data['EndTime'];

            // Configurar el mensaje del correo
            $subject = ($state == 2) ? "Estado de tu reserva en - $restaurant" : "Estado de tu reserva en - $restaurant";
            $body = ($state == 2) ? 
            "Nos complace informarle que su reservación para el $date de $start_time a $end_time en $restaurant ha sido confirmada. 
            Esperamos su estadía sea de lo más placentero posible y que nuestros servicios satisfagan sus necesidades. 🙌 " :
            "Lamentamos profundamente que su reservación para el $date de $start_time a $end_time en $restaurant haya sido cancelada.
            El motivo de dicha cancelación es por problemas ajenos a usted, pero si tiene dudas, puede contactarse directamente
            con nosotros. ";

            // Enviar el correo utilizando el archivo sendEmail.php
            sendEmail($email, $subject, $body);
        }

        } else{
            $response['success'] = false;
            $response['Error'] = 'Error al actualizar datos';
        }

    } catch(PDOException $e){
        $response['success'] = false;
            $response['Error'] = ' Exception al actualizar datos' . $e->getMessage();

    } 
        return $response;    
    }
   }
?>

