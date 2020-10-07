 /**
  * @author Manuel Mendoza
  * @version 30/09/2020
  * Views/branch.blade.php
  */
 // Validate type document and route
 $(document).ready(function() {
     const branch = document.getElementById('branch');

     branch.addEventListener('change', (event) => {
         checkFile(event);
     });

     function checkFile(e) {

         const fileList = event.target.files;
         let error = false;
         for (let i = 0, file; file = fileList[i]; i++) {

             let sFileName = file.name;
             let sFileExtension = sFileName.split('.')[sFileName.split('.').length - 1].toLowerCase();
             let iFileSize = file.size;

             if (!(sFileExtension === "xlsx" ||
                     sFileExtension === "xls") || iFileSize > 10485760) { /// 10 mb
                 error = true;
             }
         }
         if (error) {
             missingText("El archivo ingresado no es aceptado o su tamaño excede lo aceptado");
             document.getElementById("branch").value = "";
         }
     }

     function missingText(textError) {
         swal.fire({
             title: "Favor de checar tu archivo xls",
             type: "error",
             text: textError,
             icon: "error",
             timer: 3000,
             showCancelButton: false,
             showConfirmButton: false
         });
     }

     $('#btnExportBranch').click(function() {
         loader('Guardando Archivo');
     });

     function loader(message) {
         Swal.fire({
             title: message,
             timer: 5000,
             onBeforeOpen: () => {
                 Swal.showLoading();
             },
         }).then((result) => {

         });
     }
 });