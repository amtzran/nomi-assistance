$(document).ready(function() {
//start modal new users
    $('#userNew').click(function() {
        let name = $('#name').val();
        let email = $('#email').val();
        let password = $('#password').val();
        let id_rol = $('#rol').val();
        $.ajax({
            type: 'POST',
            url: "../create/user",
            data: {
                _token: $("meta[name=csrf-token]").attr("content"),
                name: name,
                email : email,
                password : password,
                id_rol : id_rol
            },
            success: function(data) {
                if (data.errors) {
                    faltante();
                }
                else{
                    correcto();
                    location.reload();
                }
            }
        });
    });

//end modal new employees



//sweet alert
    function correcto() {
        swal({
            title: "Datos guardados correctamente",
            text: " ",
            icon: "success",
            button: false,
            timer: 2000
        });
    }

    function faltante() {
        swal({
            title: "Ha ocurrido un error",
            text: " ",
            icon: "error",
            button: false,
            timer: 2000
        });
    }
//end sweet alert

});
