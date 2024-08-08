<?php
require_once '../db/db.php';

function obtenerReservacionesAdmin($user_id) {
    global $conexion;
    $reservaciones = array('pending' => [], 'confirmed' => [], 'canceled' => []);

    $sql = "SELECT
    r.Id_Reservation,
    u.Name, 
    rest.Name,
    tt.Type_Name,
    r.ReservationDate,
    r.StartTime,
    r.EndTime,
    r.Number_People,
    r.State
FROM
    reservation r
JOIN
    users u ON r.Id_User = u.Id_User
JOIN
    tables t ON r.Id_Table = t.Id_Table
join 
	table_type tt on t.Id_TableType = tt.Id_TableType 
JOIN
    restaurant rest ON r.Id_Rest = rest.Id_Rest
JOIN
    restaurant_admins ra ON ra.Id_Rest = rest.Id_Rest
WHERE
    ra.Id_User = ?;";
            
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