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
 });