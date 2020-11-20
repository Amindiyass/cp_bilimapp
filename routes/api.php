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

/**Route for login API */
Route::post('login', 'Api\AuthController@login');

/**Route for register API */
Route::post('register', 'Api\AuthController@register');

/**Route for details user API */
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('details', 'Api\AuthController@user_info');
});

