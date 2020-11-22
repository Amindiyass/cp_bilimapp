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
Route::post('registration/send_code', 'Api\AuthController@sendConfirmationPhone');
Route::post('registration/confirm_code', 'Api\AuthController@confirmAndRegister');

/**Route for details user API */
Route::group([
    'namespace' => 'Api',
    'middleware' => ['excludeObligation', 'auth:api']
], function () {

    Route::post('details', 'AuthController@user_info');
    Route::get('course/{course}', 'CourseController@show');
    Route::get('course/{course}/details', 'CourseController@details');
    Route::get('course/{course}/tests', 'CourseController@tests');

    Route::get('courses/all', 'CourseController@all');
    Route::get('courses/filter', 'CourseController@filter');
    Route::get('courses/search', 'CourseController@search');
    Route::get('course/filter/attributes', 'CourseController@filter_attributes');
    Route::get('course/filter/variants', 'CourseController@filter_variants');

    Route::get('languages/all', 'LanguagesController@all');

});

