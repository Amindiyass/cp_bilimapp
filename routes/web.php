<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes();
Route::redirect('/home', 'admin/home');
Route::redirect('/', 'login');

Route::group([
    'middleware' => 'auth',
    'namespace' => 'Admin',
    'prefix' => 'admin',
], function () {
    Route::get('home', 'HomeController@index')->name('home.index');
    Route::resource('student', 'StudentController');
    Route::post('students/ajax', 'StudentController@ajax')->name('student.ajax');
    Route::get('students/filter', 'StudentController@filter')->name('student.filter');
    Route::post('students/password/change', 'StudentController@password_change')->name('student.password.change');
    Route::post('students/add/subscription', 'StudentController@add_subscription')->name('student.add.subscription');
    Route::post('students/extend/subscription', 'StudentController@extend_subscription')->name('student.extend.subscription');

    Route::resource('test', 'TestController');
    Route::post('tests/ajax', 'TestController@ajax')->name('test.ajax');


    Route::resource('variant', 'TestVariantController');
    Route::post('variant/add', 'TestVariantController@add')->name('variant.add');
    Route::post('variant/modify', 'TestVariantController@update')->name('variant.modify');
    Route::post('variant/ajax', 'TestVariantController@ajax')->name('variant.ajax');


    Route::resource('question', 'QuestionController');
    Route::post('question/add', 'QuestionController@add')->name('question.add');


});

