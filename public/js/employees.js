$(document).ready(function() {
    //start modal new employees save
    $('#employeeNew').click(function() {

        // Variables input
        let clave = $('#clave').val();
        let nss = $('#nss').val();
        let id_sucursal = $('#sucursal option:selected').val();
        let nombre = $('#nombre').val();
        let apellido_paterno = $('#apellido_paterno').val();
        let apellido_materno = $('#apellido_materno').val();
        let id_turno = $('#turno option:selected').val();

        // //validations
        // if (clave === "") missingText('Ingresa la clave del Empleado');
        // else if (nss.length > 11) missingText('El numero de seguro social no debe ser mayor a 11 digitos');
        // else if (id_sucursal == 0) missingText('Debes de seleccionar una Sucursal');
        // else if (nombre === "") missingText('Ingresa el nombre del Empleado');
        // else if (nombre.length > 255) missingText('Debes ingresar un texto más corto que no exceda los 255 carácteres');
        // else if (apellido_paterno === "") missingText('Ingresa el apellido paterno del Empleado');
        // else if (apellido_paterno.length > 255) missingText('Debes ingresar un texto más corto que no exceda los 255 carácteres');
        // else if (turno === "") missingText('Ingresa el turno del Empleado');
        // else saveCaptureEmpleado();

        $.ajax({
            type: 'POST',
            url: "../create/employee",
            data: {
                _token: $("meta[name=csrf-token]").attr("content"),
                clave: clave,
                nss: nss,
                id_sucursal: id_sucursal,
                nombre: nombre,
                apellido_paterno: apellido_paterno,
                apellido_materno: apellido_materno,
                id_turno: id_turno
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