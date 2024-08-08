$(document).ready(function() {
    function obtenerReservaciones() {
        $.ajax({
            url: '../routes/historialReservas_route.php',
            type: 'POST',
            success: function(data) {
                try {
                    var reservaciones = JSON.parse(data);
                    console.log('Reservaciones:', reservaciones);
                    actualizarReservaciones(reservaciones);
                } catch (e) {
                    console.error('Error al parsear JSON:', e);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud AJAX:', error);
            }
        });
    }

    function actualizarReservaciones(reservaciones) {
        $('#reservationsAccordion').empty();
        $('#confirmedAccordion').empty();
        $('#canceledAccordion').empty();

        reservaciones.pending.forEach(function(reservacion) {
            $('#reservationsAccordion').append(generarHtmlReservacion(reservacion));
        });

        reservaciones.confirmed.forEach(function(reservacion) {
            $('#confirmedAccordion').append(generarHtmlReservacion(reservacion));
        });

        reservaciones.canceled.forEach(function(reservacion) {
            $('#canceledAccordion').append(generarHtmlReservacion(reservacion));
        });
    }

    function generarHtmlReservacion(reservacion) {
        var estado_text = (reservacion.State == '1') ? "En Espera" : ((reservacion.State == '2') ? "Confirmada" : "Cancelada");
        var botones = (reservacion.State == '1') ? `<button class="btn botonConfi" data-id="${reservacion.Id_Reservation}"> Confirmar </button>
                                                     <button class="btn botonCance" data-id="${reservacion.Id_Reservation}"> Cancelar </button>` : '';

        return `
        <div class="card">
            <div class="card-header" id="headingCurrent${reservacion.Id_Reservation}">
                <h5 class="mb-0">
                    <button class="btn accordion-button" type="button" data-toggle="collapse" data-target="#collapseCurrent${reservacion.Id_Reservation}" aria-expanded="true" aria-controls="collapseCurrent${reservacion.Id_Reservation}">
                        Reservación ${reservacion.Name} ${reservacion.ReservationDate} 
                    </button>
                </h5>
            </div>
            <div id="collapseCurrent${reservacion.Id_Reservation}" class="collapse" aria-labelledby="headingCurrent${reservacion.Id_Reservation}" data-parent="#reservationsAccordion">
                <div class="card-body">
                    <p>Fecha: ${reservacion.ReservationDate}</p>
                    <p>Hora: ${reservacion.StartTime} - ${reservacion.EndTime}</p>
                    <p>Restaurante: ${reservacion.Name}</p>
                    <p>Tipo de mesa reservada: ${reservacion.Type_Name}</p>
              
                </div>
            </div>
        </div>`;
    }

    obtenerReservaciones();
    setInterval(obtenerReservaciones, 30000);
});