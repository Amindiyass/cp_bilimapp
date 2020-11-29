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
Route::group(['middleware' => [
    'excludeObligation', 'auth:api',
]], function () {

    Route::get('courses/all', 'Api\CourseController@all');
    Route::get('courses/filter', 'Api\CourseController@filter');
    Route::get('courses/search', 'Api\CourseController@search');
    Route::get('course/filter/attributes', 'Api\CourseController@filter_attributes');
    Route::get('course/filter/variants', 'Api\CourseController@filter_variants');

    Route::get('languages/all', 'LanguageController@all');

    Route::post('details', 'Api\AuthController@user_info');
    Route::get('course/{course}', 'Api\CourseController@show');
    Route::get('course/{course}/details', 'Api\CourseController@details');
    Route::get('course/{course}/tests', 'Api\CourseController@tests');
    Route::get('profile', 'Api\StudentController@profile');
    Route::put('profile', 'Api\StudentController@update');
    Route::post('profile/reconfirm_code', 'Api\AuthController@reconfirmCode');
});
//Route::middleware('auth:api')->group( function () {
//});

