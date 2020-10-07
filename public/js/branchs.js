$(document).ready(function() {
    //start modal new employees
    $('#branchNew').click(function() {
        let clave = $('#clave').val();
        let nombre = $('#nombre').val();

        $.ajax({
            type: 'POST',
            url: "../create/branch",
            data: {
                _token: $("meta[name=csrf-token]").attr("content"),
                clave: clave,
                nombre: nombre,
            },
            success: function(data) {
                if (data.code == 500) {
                    faltante();
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

    function faltante() {
        swal.fire({
            title: "Ha ocurrido un error",
            text: " ",
            icon: "error",
            button: false,
            timer: 2000
        });
    }
    //end sweet alert

});