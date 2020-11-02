$(document).ready(function() {
    //start modal new employees
    $('#branchNew').click(function() {
        let clave = $('#clave').val();
        let nombre = $('#nombre').val();

        //validations
        if (clave === "") missingText('Ingresa la clave de la Sucursal');
        else if (isNaN(clave)) missingText('Este campo sólo admite números');
        else if (nombre === "") missingText('Ingresa el nombre de la Sucursal');
        else if (nombre.length > 255) missingText('Debes ingresar un texto más corto que no exceda los 255 carácteres');

        else{
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
                        faltante(data.message);
                    } else {
                        correcto();
                        location.reload();
                    }
                }
            });
        }
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
    function missingText(textError) {
        swal.fire({
            title: "¡Espera!",
            type: "error",
            text: textError,
            icon: "error",
            timer: 3000,
            showCancelButton: false,
            showConfirmButton: false
        });
    }
    //end sweet alert

});
