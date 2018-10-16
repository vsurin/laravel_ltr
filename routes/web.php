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

Auth::routes();

Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'middleware' => ['auth']], function()
{
    Route::get('/', 'HomeController@index');
    Route::get('/profile', 'HomeController@edit')->name('admin.profile.edit');
    Route::resource('/users', 'UserController')->middleware('admin');
    Route::resource('/projects', 'ProjectController')->middleware('admin');
    Route::get('/project/import', 'ProjectController@import')->middleware('admin')->name('admin.project.import');
    Route::post('/project/parserFile', 'ProjectController@parserFile')->middleware('admin')->name('admin.project.parserFile');
    Route::get('/project/export', 'ProjectController@export')->middleware('admin')->name('admin.project.export');
    Route::post('/project/generate-pdf','ProjectController@generatePDF')->name('admin.project.pdf');
});

Route::group(['namespace' => 'Frontend', 'middleware' => ['auth']], function()
{
    Route::get('/', 'HomeController@index');
});