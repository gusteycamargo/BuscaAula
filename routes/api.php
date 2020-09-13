<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('subjects/load', 'SubjectController@loadJson');
Route::get('teachers/{id}', 'StudentController@showTeacher');
Route::post('solicitations', 'SolicitationController@store');
Route::delete('solicitations/{id}', 'SolicitationController@destroy');
Route::get('classes/load/{id}', 'ClassroomController@loadJsonClassesWithTeacherLogged');

Route::post('registration', 'RegistrationController@store');

Route::post('classes', 'ClassroomController@store');
Route::get('classes/{id}', 'ClassroomController@show');
Route::put('classes/{id}', 'ClassroomController@update');

Route::resource('subjects', 'SubjectController');

