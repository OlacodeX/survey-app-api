<?php

use App\Http\Controllers\Api\V1;
use App\Http\Controllers\Api\V1\Admin;
use App\Http\Controllers\Api\V1\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Public Endpoints
Route::prefix('surveys')->name('surveys.')->group(function(){
    Route::get('/{id?}', V1\GetSurveysController::class)->name('get-surveys')->whereUuid('id');
});

Route::prefix('admin')->middleware('auth:sanctum')->group(function () {
    Route::post('surveys', Admin\CreateSurveyController::class)->name('create-survey');
});

Route::post('login', Auth\LoginController::class)->name('login');
