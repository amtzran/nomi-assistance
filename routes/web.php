<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'auth'], function () {

    // Las rutas que incluyas aquí pasarán por el middleware 'auth'
    Route::name('welcome')->get('/', 'AssistanceController@index');
    Route::name('users')->get('users/app', 'AppUsersController@index');
    Route::name('createUser')->post('create/user', 'AppUsersController@create');

    //Empleados
    Route::name('employees')->get('employees', 'EmployeeController@index');
    Route::name('employee_file_upload')->post('employee/file/upload', 'EmployeeController@employeeFile');
    Route::name('createEmployee')->post('create/employee', 'EmployeeController@create');
    Route::name('updateEmployee')->post('employees/update','EmployeeController@updateEmployee');
    Route::name('deleteEmployee')->post('employees/delete','EmployeeController@deleteEmployee');
    //Sucursales
    Route::name('branch')->get('branch', 'BranchOfficeController@index');
    Route::name('branch_file_upload')->post('branch/file/upload', 'BranchOfficeController@branchFile');
    Route::name('createBranch')->post('create/branch', 'BranchOfficeController@create');
    Route::name('updateBranch')->post('branch/update','BranchOfficeController@updateBranch');
    Route::name('deleteBranch')->post('branch/delete','BranchOfficeController@deleteBranch');

    //Asistencias
    Route::name('assistance')->get('assistance', 'AssistanceController@assistance');
    Route::name('assistance_file_upload')->post('assistance/file/upload', 'AssistanceController@assistanceFile');

    //Configuraciones
    Route::name('configuration')->get('configuration', 'ConfigurationController@index');
    Route::name('createTurn')->post('create/turn', 'ConfigurationController@create');
    Route::name('updateTurn')->post('turns/update','ConfigurationController@updateTurn');
    Route::name('deleteTurn')->post('turns/delete','ConfigurationController@deleteTurn');

});

Auth::routes();
Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');
