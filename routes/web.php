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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/materiel', 'MaterialController@index')->name('materiel.index');
Route::post('/update', 'MaterialController@update')->name('materiel.update');
Route::post('/recherche', 'MaterialController@recherche')->name('materiel.recherche');
Route::post('/materiel/{id}', 'MaterialController@destroy')->name('materiel.destroy');