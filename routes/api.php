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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('v1')->middleware('jwt.auth')->group(function () {
    Route::apiResource('student', 'App\Http\Controllers\StudentController');
    Route::apiResource('school-year', 'App\Http\Controllers\SchoolYearController');
    Route::apiResource('professional-focus', 'App\Http\Controllers\ProfessionalFocusController');
    Route::apiResource('situation', 'App\Http\Controllers\SituationController');
    Route::apiResource('approved', 'App\Http\Controllers\ApprovedController');
    Route::post('me', 'App\Http\Controllers\AuthController@me');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
});


Route::post('login', 'App\Http\Controllers\AuthController@login');


