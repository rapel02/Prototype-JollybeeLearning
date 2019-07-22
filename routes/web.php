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

Route::get('/', 'PagesController@index');
/*Route::get('/problems/{slug}/create','SolutionController@create');
Route::post('/problems/{slug}/','SolutionController@store');
*/
Route::resource('materials','MaterialController');
Route::resource('users','UserController');
Route::resource('topics','TopicController');
Route::resource('files','FileController');
Route::resource('problems','ProblemController');
Route::get('/problems/tags/{slug}','ProblemController@tags');
Route::get('/materials/tags/{slug}','MaterialController@tags');
Route::get('/materials/{id}/addproblem','MaterialController@createproblem');
Route::POST('/materials/{id}/storeproblems','MaterialController@storeproblem');
Route::get('/materials/{id}/editproblem','MaterialController@editproblem');
Route::POST('/materials/{id}/updateproblems','MaterialController@updateproblem');

Route::resource('/problems/{slug}/solutions','SolutionController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');