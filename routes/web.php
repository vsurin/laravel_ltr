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
    Route::get('/', 'HomeController@index')->name('admin.home.index');

    Route::get('/profile', 'HomeController@edit')->name('admin.profile.edit');
    Route::resource('/users', 'UserController')->middleware('admin');
    Route::resource('/projects', 'ProjectController');
    Route::get('/project/import', 'ProjectController@import')->middleware('admin')->name('admin.project.import');
    Route::post('/project/parserFile', 'ProjectController@parserFile')->middleware('admin')->name('admin.project.parserFile');
    Route::get('/project/export', 'ProjectController@export')->middleware('admin')->name('admin.project.export');
    Route::get('/project/generate-pdf','ProjectController@generatePDF')->name('admin.project.pdf');
    Route::get('/project/generate-pdf/{id}','ProjectController@generatePDF');

    Route::get('/api/projects/{limit}/{offset}/{title?}/{organization?}/{filtertype?}','ApiController@index');
    Route::get('/api/project/show/{project}','ApiController@show');
    Route::get('/api/project/destroy/{id}','ApiController@destroy');
    Route::post('/api/project/create','ApiController@create')->name('admin.api.project.create');
    Route::get('/api/project/create-test','ApiController@createTest');
    Route::post('/api/project/update/{id}','ApiController@update')->name('admin.api.project.update');
    Route::get('/api/project/update-test/{id}','ApiController@updateTest');
    Route::get('/api/project/count/{title?}/{organization?}/{filtertype?}','ApiController@count');

    Route::get('/projects-vue', 'ProjectVueController@index');
    Route::get('/projects-vue/show/{id}', 'ProjectVueController@show');
    Route::get('/projects-vue/create', 'ProjectVueController@create');
});

Route::group(['namespace' => 'Frontend', 'middleware' => ['auth']], function()
{
    Route::post('/update/{user}', 'HomeController@update')->name('frontend.home.update');
    Route::get('/', 'HomeController@index')->name('home/index');
});