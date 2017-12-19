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

Route::get('/', 'HomeController@index')->name('index');

Auth::routes();

// We let the user make a reservation...
Route::get('/reserve', 'ReservationController@create')->name('reserve');
Route::get('/search', 'ReservationController@search')->name('reserve_search');
Route::post('/save', 'ReservationController@save')->name('reserve_save');
Route::get('/choose', 'ReservationController@choose')->name('reserve_choose');
Route::post('/save_instruments', 'ReservationController@save_instruments')->name('reserve_save_instruments');

// ...and only then ask them to sign up
Route::middleware(['auth'])->group(function() {
    Route::get('/complete', 'ReservationController@complete')->name('reserve_complete');
    Route::get('/home', 'HomeController@home')->name('home');
});

Route::middleware(['auth', 'IsAdmin'])->prefix('dashboard')->group(function() {
    Route::prefix('clients')->group(function() {
        Route::get('/', 'Backend\ClientController@viewAll')->name('clients');
        Route::get('view/{id}', 'Backend\ClientController@view')->name('view_client');
        Route::get('edit/{id}', 'Backend\ClientController@edit')->name('edit_client');
        Route::post('save', 'Backend\ClientController@save')->name('save_client');
    });

    Route::prefix('instruments')->group(function() {
        Route::get('/', 'Backend\InstrumentController@viewAll')->name('instruments');
        Route::get('view/{id}', 'Backend\InstrumentController@view')->name('view_instrument');
        Route::get('edit/{id}', 'Backend\InstrumentController@edit')->name('edit_instrument');
        Route::post('save', 'Backend\InstrumentController@save')->name('save_instrument');
    });

    Route::prefix('rooms')->group(function() {
        Route::get('/', 'Backend\RoomController@viewAll')->name('rooms');
        Route::get('view/{id}', 'Backend\RoomController@view')->name('view_room');
        Route::get('edit/{id}', 'Backend\RoomController@edit')->name('edit_room');
        Route::post('save', 'Backend\RoomController@save')->name('save_room');
    });
});
