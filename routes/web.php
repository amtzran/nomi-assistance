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

    Route::name('employees')->get('employees', 'EmployeeController@index');
    Route::name('employee_file_upload')->post('employee/file/upload', 'EmployeeController@employeeFile');

    Route::name('branch')->get('branch', 'BranchOfficeController@index');
    Route::name('branch_file_upload')->post('branch/file/upload', 'BranchOfficeController@branchFile');

    Route::name('assistance')->get('assistance', 'AssistanceController@assistance');
    Route::name('assistance_file_upload')->post('assistance/file/upload', 'AssistanceController@assistanceFile');

});

Auth::routes();
Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');
