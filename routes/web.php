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
Route::redirect('/', 'en');

Route::group(['prefix' => '{language}'], function(){

    Route::get('/', function () {
        return view('welcome');
    });
    
    Route::get('/employee/create','App\Http\Controllers\HomeController@create')->name('create');
    Route::post('employee/store','App\Http\Controllers\HomeController@store')->name('store');
    
    
    
    
    
    Auth::routes(['register' => false]);
    
    Route::get('/employee/list', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

Route::get('{language}/employee/edit/{id}','App\Http\Controllers\HomeController@edit')->name('edit');
Route::post('{id}/employee/update/{language}','App\Http\Controllers\HomeController@update')->name('update');
Route::get('{id}/employee/delete/{language}','App\Http\Controllers\HomeController@delete')->name('delete');




