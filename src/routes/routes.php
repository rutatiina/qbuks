<?php

Route::group(['middleware' => ['web', 'auth']], function() {

    Route::resource('admin/services/users', 'Rutatiina\Qbuks\Http\Controllers\ServiceUserController', ['as' => 'admin.services']);
    Route::resource('admin/services', 'Rutatiina\Qbuks\Http\Controllers\ServiceController', ['as' => 'admin']);
    Route::resource('admin/users', 'Rutatiina\Qbuks\Http\Controllers\UserController', ['as' => 'admin']);
    Route::resource('admin', 'Rutatiina\Qbuks\Http\Controllers\QbuksController');

});
