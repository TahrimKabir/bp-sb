<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\CourseListController;
use  App\Http\Controllers\QuestionController;
use  App\Http\Controllers\QuestionListController;
use  App\Http\Controllers\CertificateController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ExamListController;
use App\Http\Controllers\ScheduleListController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/course-list',[CourseListController::class,'index']);

// Route::post('/schedule-created',[ScheduleController::class,'update'])->name('schedule-created');
// Route::get('/create-question/{id}',[QuestionController::class,'getCourse']);
// Route::post('/question-created',[QuestionController::class,'store'])->name('question-created');


// Route::get('/generate-certificate/{id}', [CertificateController::class, 'generateCertificate']);

Route::get('/questionlist',[QuestionListController::class,'index']);
Route::get('/edit/question/{id}',[QuestionListController::class,'edit']);
Route::post('/question-updated',[QuestionListController::class,'update'])->name('question-updated');
Route::get('/delete/question/{id}',[QuestionListController::class,'delete']);
// exam
Route::get('/create-exam',[ExamController::class,'index']);
Route::post('/exam-added',[ExamController::class,'store'])->name('store-exam');
// exam-list
Route::get('/exam-list',[ExamListController::class,'index']);
Route::get('/edit/exam/{id}',[ExamListController::class,'edit']);
Route::post('/exam-updated',[ExamListController::class,'update'])->name('update-exam');
Route::get('/delete/exam/{id}',[ExamListController::class,'delete']);

Route::get('/create-schedule',[ScheduleController::class,'index']);
Route::post('/schedule-created',[ScheduleController::class,'store'])->name('store-schedule');


Route::get('/schedule-list',[ScheduleListController::class,'index']);
Route::get('/edit/schedule/{id}',[ScheduleListController::class,'edit']);
Route::post('/schedule-updated',[ScheduleListController::class,'update'])->name('update-schedule');
Route::get('/delete/schedule/{id}',[ScheduleListController::class,'delete']);