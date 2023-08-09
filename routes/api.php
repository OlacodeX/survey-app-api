<?php

use App\Http\Controllers\Api\V1;
use App\Http\Controllers\Api\V1\Admin;
use App\Http\Controllers\Api\V1\Admin\DeleteSurveyController;
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
Route::prefix('/surveys')->name('surveys.')->group(function(){
    Route::get('/{id?}', V1\GetSurveysController::class)->name('get-surveys')->whereUuid('id');
    Route::prefix('/{id}')->group(function(){
        Route::prefix('/answers')->group(function(){
            Route::post('/', V1\CreateAnswersController::class)->name('create-survey-question-answers');
        });
        Route::prefix('/questions')->group(function(){
            Route::get('/{question_id?}', V1\GetSurveyQuestionsController::class)->name('get-surveys-questions')->whereUuid('question_id');
        });
    })->whereUuid('id');
});

// Auth guarded endpoints
Route::prefix('admin')->middleware('auth:sanctum')->group(function () {
    Route::prefix('/surveys')->name('surveys.')->group(function(){
        Route::post('/', Admin\CreateSurveyController::class)->name('create-survey');
        Route::prefix('/{id}')->group(function(){
            Route::patch('/', Admin\EditSurveyController::class)->name('edit-survey');
            Route::delete('/', Admin\DeleteSurveyController::class)->name('delete-survey');
            Route::prefix('/questions')->group(function(){
                Route::post('/', Admin\CreateSurveyQuestionController::class)->name('create-survey-question');
                Route::prefix('/{question_id}')->group(function(){
                    Route::get('/answers', Admin\GetSurveyQuestionAnswersController::class)->name('get-survey-question-answers');
                    Route::patch('/', Admin\EditSurveyQuestionController::class)->name('edit-survey-question');
                    Route::delete('/', Admin\DeleteSurveyQuestionController::class)->name('delete-survey-question');
                })->whereUuid('question_id');
            });
        })->whereUuid('id');
    });
});

Route::post('login', Auth\LoginController::class)->name('login');
