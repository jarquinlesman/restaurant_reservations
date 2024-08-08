$(document).ready(function () {
    function loadReservations() {
        $.ajax({
            url: '../routes/restauranteAdmin_route.php',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                console.log("Response from server: ", data);
                updateReservations(data);
            },
            error: function (xhr, status, error) {
                console.error("Error en la solicitud Ajax: " + error);
                console.error("Response text: " + xhr.responseText);
            }
        });
    }

    function updateReservations(data) {
        $('#reservationsAccordion').empty();
        $('#confirmedAccordion').empty();
        $('#canceledAccordion').empty();

        data.pending.forEach(function (reservacion) {
            $('#reservationsAccordion').append(createReservationCard(reservacion, true));
        });

        data.confirmed.forEach(function (reservacion) {
            $('#confirmedAccordion').append(createReservationCard(reservacion, false));
        });

        data.canceled.forEach(function (reservacion) {
            $('#canceledAccordion').append(createReservationCard(reservacion, false));
        });
    }

    function createReservationCard(reservacion, showButtons) {
        let estado_text = (reservacion.State === '1') ? "En Espera" : ((reservacion.State === '2') ? "Confirmada" : "Cancelada");
        let buttons = '';

        if (showButtons) {
            buttons = `
                <button class="btn botonConfi" data-id="${reservacion.Id_Reservation}">Confirmar</button>
                <button class="btn botonCance" data-id="${reservacion.Id_Reservation}">Cancelar</button>`;
        }

        return `
            <div class="card">
                <div class="card-header" id="heading${reservacion.Id_Reservation}">
                    <h5 class="mb-0">
                        <button class="btn accordion-button" type="button" data-toggle="collapse" data-target="#collapse${reservacion.Id_Reservation}" aria-expanded="true" aria-controls="collapse${reservacion.Id_Reservation}">
                            Reservación ${reservacion.Name} ${reservacion.ReservationDate}
                        </button>
                    </h5>
                </div>
                <div id="collapse${reservacion.Id_Reservation}" class="collapse" aria-labelledby="heading${reservacion.Id_Reservation}" data-parent="#reservationsAccordion">
                    <div class="card-body">
                        <p>Fecha: ${reservacion.ReservationDate}</p>
                        <p>Hora: ${reservacion.StartTime} - ${reservacion.EndTime}</p>
                        <p>Restaurante: ${reservacion.Name}</p>
                        <p>Tipo de mesa reservada: ${reservacion.Type_Name}</p>
                        ${buttons}
                    </div>
                </div>
            </div>`;
    }

    $('body').on('click', '.botonConfi', function() {
        var id = $(this).data('id');
        updateReservationState(id, 2);
        //alert('Reservación Confirmada Exitosamente', )
    });

    $('body').on('click', '.botonCance', function() {
        var id = $(this).data('id');
        updateReservationState(id, 3);
        
    });

    function updateReservationState(id, state) {
        $.ajax({
            url: '../routes/reservasAdmin_route.php',
            method: 'POST',
            data: {
                id_res: id,
                state: state
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    loadReservations();
                } else {
                    console.error("Error en la actualización: " + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error en la solicitud Ajax: " + error);
                console.error("Response text: " + xhr.responseText);
            }
        });
    }
    
    loadReservations();
    setInterval(loadReservations, 30000);
});