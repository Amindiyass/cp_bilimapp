<?php

use App\Http\Controllers\Admin\Ajax\LessonController;
use App\Http\Controllers\Admin\Ajax\SectionController;
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


    Route::resource('subject', 'SubjectController');
    Route::resource('solution', 'SolutionController');

    Route::resource('course', 'CourseController')->except('show');
    Route::post('course/section', 'CourseController@tempSectionSave')->name('course.section');

    Route::get('sections/ajax', [SectionController::class, 'index']);
    Route::get('lessons/ajax', [LessonController::class, 'index']);

    Route::resource('lesson', 'LessonController');
    Route::post('lesson/video', 'LessonController@tempVideoSave')->name('lesson.video');
    Route::post('lesson/conspectuses', 'LessonController@tempConspectusesSave')->name('lesson.conspectuses');
    Route::post('lesson/ajax', 'LessonController@ajax')->name('lesson.ajax');
    Route::get('lesson/video/reset', 'LessonController@videoReset')->name('lesson.video.reset');
    Route::get('lesson/conspectus/reset', 'LessonController@conspectusReset')->name('lesson.conspectus.reset');

    Route::resource('stuff', 'StuffController');
    Route::post('stuff/password/change', 'StuffController@password_change')->name('stuff.password.change');
    Route::post('stuff/deactivate', 'StuffController@deactivate')->name('stuff.deactivate');
    Route::post('stuff/activate', 'StuffController@activate')->name('stuff.activate');

    Route::get('configuration/show', 'ConfigurationController@show')->name('configuration.show');
    Route::get('course/filter', 'CourseController@filter')->name('course.filter');

    Route::get('assignment/filter', 'AssignmentController@filter');
    Route::resource('assignment', 'AssignmentController');
    Route::post('assignment/ajax', 'AssignmentController@ajax');


});

