 /**
  * @author Manuel Mendoza
  * @version 30/09/2020
  * Views/app.blade.php
  */
 // Validate type document and route
 $(document).ready(function() {

     const url = window.location.href;
     urlseparate = url.split('/');

     if (urlseparate[3] == "users") {
         $('#users-nav').addClass("active");
         console.log('entro');
     }
     if (urlseparate[3] == "employees") {
         $('#employees-nav').addClass("active");
         console.log('entro');
     }
     if (urlseparate[3] == "branch") {
         $('#branch-nav').addClass("active");
         console.log('entro');
     }
     if (urlseparate[3] == "assistance") {
         $('#assitance-nav').addClass("active");
         console.log('entro');
     }

     // Change password
     const optionChangePassword = document.getElementById('changePassword');
     optionChangePassword.onclick = function () {
         $('#modalChangePassword').modal("show");
     }

     const btnChangePassword = document.getElementById('btnChangePassword');
     btnChangePassword.onclick = function () {
         const newPassword = document.getElementById('newPassword').value;
         const confirmPassword = document.getElementById('confirmPassword').value;

         //validations
         if (newPassword === "") missingText('Debes ingresar una contraseña valida.');
         else if (confirmPassword === "") missingText('Debes confirmar la contraseña.');
         else if (newPassword.length < 6) missingText('La contraseña debe tener al menos 6 caracteres.');
         else if (confirmPassword !== newPassword) missingText('Las contraseñas no coinciden.');
         else {
             $.ajax({
                 type: 'POST',
                 url: "../change/user/password",
                 data: {
                     _token: $("meta[name=csrf-token]").attr("content"),
                     newPassword: newPassword
                 },
                 success: function(data) {
                     if (data.code === 500) {
                         faltante(data.message);
                     } else {
                         correcto();
                         location.reload();
                     }
                 }
             });
         }

     }

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