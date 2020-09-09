<?php

use Illuminate\Support\Facades\Route;

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
//inicio do app
Route::get('/', function () {
    return view('home');
})->name('initial');

Route::get('/negado', function () {
    return view('negado.index');
})->middleware('auth');


//auth professor
Route::get('/teacher/login', 'Auth\TeacherLoginController@index')->name('login-teacher');
Route::post('/teacher/login', 'Auth\TeacherLoginController@login')->name('login-teacher-submit');
Route::post('/teacher/logout', 'Auth\TeacherLoginController@logout')->name('logout-teacher');
Route::post('/teacher/register', 'Auth\TeacherRegisterController@register')->name('register-teacher');
Route::get('/teacher/register', function () {
    return view('auth.register-teacher');
});

//auth aluno
Auth::routes();

//paginas aluno
Route::get('/home',function () {
    return view('main.main');
})->name('home')->middleware('auth');;
Route::get('/provas', 'Provas@index')->name('prova')->middleware('auth');
Route::get('/teachers', 'StudentController@index')->name('teacher')->middleware('auth');
Route::get('/profile', 'StudentController@profile')->name('profile')->middleware('auth');
Route::post('/filter', 'StudentController@filter')->name('filter')->middleware('auth');

//paginas professor
Route::resource('matriculas', 'Matriculas')->middleware('auth:teacher');
Route::get('/alunosmatricula/{id}', 'Alunos@redirectMatricula')->middleware('auth:teacher');
Route::resource('alunos', 'Alunos')->middleware('auth:teacher');
Route::resource('subjects', 'SubjectController')->middleware('auth:teacher');
Route::resource('disciplinas', 'Disciplinas')->middleware('auth:teacher');
Route::resource('professores', 'Professores')->middleware('auth:teacher');
Route::get('/teacher', 'TeacherController@home')->name('home-teacher');