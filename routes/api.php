<?php

use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\AssignmentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\DictionaryController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\Api\VideoController;
use App\Http\Controllers\LanguageController;
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
Route::post('login', [AuthController::class, 'login']);

/**Route for register API */
// Route::post('register', 'Api\AuthController@register');
Route::post('registration/send_code', [AuthController::class, 'sendConfirmationPhone']);
Route::post('registration/confirm_code', [AuthController::class, 'confirmAndRegister']);

Route::get('areas', [DictionaryController::class, 'areas']);
Route::get('schools', [DictionaryController::class, 'schools']);
Route::get('regions', [DictionaryController::class, 'regions']);
Route::get('languages', [DictionaryController::class, 'languages']);
Route::get('classes', [DictionaryController::class, 'classes']);
Route::get('subjects', [DictionaryController::class, 'subjects']);
Route::get('courses', [CourseController::class, 'all']);

/**Route for details user API */
Route::group(['middleware' => [
    'excludeObligation', 'auth:api',
]], function () {

    Route::post('logout', [AuthController::class, 'logout']);

    Route::post('application', [ApplicationController::class, 'store']);

    Route::post('details', [AuthController::class, 'user_info']);

    Route::get('courses/filter', [CourseController::class, 'filter']);
    Route::get('courses/search', [CourseController::class, 'search']);
    Route::get('user-courses', [CourseController::class, 'index']);
    Route::get('course/{course}', [CourseController::class, 'show'])->name('course.show');
    Route::get('course/{course}/details', [CourseController::class, 'details']);
    Route::get('course/{course}/tests', [CourseController::class, 'tests']);


    Route::get('lesson/{lesson}', [LessonController::class, 'show'])->middleware('hasSubscription')->name('api.lesson');

    Route::get('profile', [StudentController::class, 'profile']);
    Route::put('profile', [StudentController::class, 'update']);
    Route::post('profile/reconfirm_code', [AuthController::class, 'reconfirmCode']);

    Route::middleware('hasSubscription')->group(function () {
        Route::get('test/{test}', [TestController::class, 'show'])->middleware('testPassed')->name('api.test');
        Route::post('test/check/{test}', [TestController::class, 'check'])->middleware('testPassed')->name('api.test.check');
        Route::get('test/errors/{test}', [TestController::class, 'errors'])->middleware('testPassed')->name('api.test.error');
        Route::get('lesson/{lesson}/assignments', [LessonController::class, 'assignments'])->name('api.assignments');
        Route::get('assignment/{assignment}', [AssignmentController::class, 'show'])->name('api.task');
        Route::get('assignment/{assignment}/solution', [AssignmentController::class, 'solution'])->name('api.task.solutions');
        Route::get('assignments/search', [AssignmentController::class, 'search'])->name('api.assignments.search');
        Route::post('video/{video}/store-progress', [VideoController::class, 'storeProgress']);
    });

    Route::get('user/subscriptions', [SubscriptionController::class, 'user'])->name('api.user.subscriptions');
    Route::get('subscriptions', [SubscriptionController::class, 'index'])->name('api.subscriptions');
    Route::get('user/subscription/expiry', [SubscriptionController::class, 'expiry'])->name('api.user.subscription.expiry');
});

