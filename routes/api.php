<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * CABECERAS SEGURIDAD API REST APP
 */
/*-- START CABECERAS -- */
header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, GX-Auth-Token, Origin, Authorization');
/*-- START CABECERAS -- */



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['prefix' => 'v1','middleware' => 'auth:api'], function () {});


#region JSON

Route::group(['prefix' => 'js'], function () {

    //Prefijo para el modulo de tareas.
    Route::group(['prefix' => 'assistance'], function () {

        /**
         * Ruta para obtener una tarea por su Id.
         *
         * @url public/circlek/api/js/task/task/{id}
         */
        Route::get('/sucursales', 'AssistanceController@getSucByJson');

        Route::get('/employees', 'AssistanceController@getEmployeesByJson');

        /**
         * Guarda una nueva asistencia por empleado.
         */
        Route::post('/save/assistance', 'AssistanceController@saveAssistance');


        /**
         * Retorna un LoginResponse en base a los datos de sesión del usuario desde la app.
         * @url public/api/js/user/authenticate/{email}/{password}
         */
        Route::post('/authenticate/login', 'Auth\LoginController@authenticate');

    });

});
