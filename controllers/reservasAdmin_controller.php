<?php
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

require_once '../db/db.php';

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

