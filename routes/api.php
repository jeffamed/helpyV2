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

Route::post('login', 'Auth\LoginController@login')->name('loginApi');

Route::namespace('Api')->group(function() {
    Route::post('login-extern','LoginController')->name('verificate-login');
    Route::post('add-ticket','TicketsController@store')->name('api-add-ticket.store');
    Route::get('departments', 'DepartmentsController@index')->name('api-departments');
    Route::get('customfield', 'CustomFieldController@index')->name('api-customfield');
});
