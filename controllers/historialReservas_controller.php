<?php
require_once '../db/db.php';

function obtenerReservaciones($user_id) {
    global $conexion;
    $reservaciones = array('pending' => [], 'confirmed' => [], 'canceled' => []);

    $sql = "SELECT r.Id_Reservation, res.Name, tt.Type_Name, r.ReservationDate, r.StartTime, r.EndTime, r.State
            FROM reservation r
            JOIN restaurant res ON r.Id_Rest = res.Id_Rest
            JOIN tables t ON r.Id_Table = t.Id_Table
            JOIN table_type tt ON t.Id_TableType = tt.Id_TableType 
            WHERE r.Id_User = ?;";
            
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if ($row['State'] == '1') {
                $reservaciones['pending'][] = $row;
            } elseif ($row['State'] == '2') {
                $reservaciones['confirmed'][] = $row;
            } else {
                $reservaciones['canceled'][] = $row;
            }
        }
    }

    $stmt->close();
    return $reservaciones;
} 
?>
