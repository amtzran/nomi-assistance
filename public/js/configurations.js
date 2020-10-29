$(document).ready(function() {
    //start modal new employees save
    $('#turnNew').click(function() {

        // Variables input
        let nombre_turno = $('#nombre_turno').val();
        let hora_entrada = $('#hora_entrada').val();
        let hora_salida = $('#hora_salida').val();

        $.ajax({
            type: 'POST',
            url: "../create/turn",
            data: {
                _token: $("meta[name=csrf-token]").attr("content"),
                nombre_turno: nombre_turno,
                hora_entrada: hora_entrada,
                hora_salida: hora_salida,
            },
            success: function(data) {
                if (data.code == 500) {
                    faltante(data.message);
                } else {
                    correcto();
                    location.reload();
                }
            }
        });
    });

    //end modal new employees
    //sweet alert
    function correcto() {
        swal.fire({
            title: "Datos guardados correctamente",
            text: " ",
            icon: "success",
            button: false,
            timer: 2000
        });
    }

    function faltante(message) {
        swal.fire({
            title: message,
            text: " ",
            icon: "error",
            button: false,
            timer: 2000
        });
    }
    //end sweet alert

});