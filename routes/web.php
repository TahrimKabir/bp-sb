<?php

use App\Http\Controllers\BasicComputerTestController;
use App\Http\Controllers\ComputerTestController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseListController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ExamListController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuestionListController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ScheduleListController;
use App\Http\Controllers\TypingTestController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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


Route::group(['middleware' => 'auth:web,member'], function () {
    // Routes accessible by both admin and member users
    Route::get('/admin/homepage', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/course-list', [CourseListController::class, 'index']);
    // Add more routes accessible by both admin and member users here...
});
Route::group(['middleware' => [ 'auth']], function () {
//    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/course-list', [CourseListController::class, 'index']);

// Route::post('/schedule-created',[ScheduleController::class,'update'])->name('schedule-created');
    Route::get('/create-question', [QuestionController::class, 'index']);
    Route::post('/question-created', [QuestionController::class, 'store'])->name('question-created');

// Route::get('/generate-certificate/{id}', [CertificateController::class, 'generateCertificate']);

    Route::get('/questionlist', [QuestionListController::class, 'index']);
    Route::get('/edit/question/{id}', [QuestionListController::class, 'edit']);
    Route::post('/question-updated', [QuestionListController::class, 'update'])->name('question-updated');
    Route::get('/delete/question/{id}', [QuestionListController::class, 'delete']);
// exam
    Route::get('/create-exam', [ExamController::class, 'index']);
    Route::post('/exam-added', [ExamController::class, 'store'])->name('store-exam');
// exam-list
    Route::get('/exam-list', [ExamListController::class, 'index']);
    Route::get('/edit/exam/{id}', [ExamListController::class, 'edit']);
    Route::post('/exam-updated', [ExamListController::class, 'update'])->name('update-exam');
    Route::get('/delete/exam/{id}', [ExamListController::class, 'delete']);

    Route::get('/create-schedule', [ScheduleController::class, 'index']);
    Route::post('/schedule-created', [ScheduleController::class, 'store'])->name('store-schedule');

    Route::get('/schedule-list', [ScheduleListController::class, 'index']);
    Route::get('/edit/schedule/{id}', [ScheduleListController::class, 'edit']);
    Route::post('/schedule-updated', [ScheduleListController::class, 'update'])->name('update-schedule');
    Route::get('/delete/schedule/{id}', [ScheduleListController::class, 'delete']);

    //typing test questions
    Route::get('/typing-test-question-list',[TypingTestController::class,'showQuestionList']);
    Route::get('/create-typing-test-question',[TypingTestController::class,'createQuestion']);
    Route::post('/store-typing-test-question',[TypingTestController::class,'storeQuestion']);
    Route::get('/edit-typing-test-question/{id}',[TypingTestController::class,'editQuestion']);
    Route::post('/update-typing-test-question',[TypingTestController::class,'updateQuestion']);
    Route::delete('/delete-typing-test-question/{id}', [TypingTestController::class, 'deleteQuestion']);


    //Computer Test Questions
    Route::get('/computer-test-question-list',[ComputerTestController::class,'showQuestionSetList']);
    Route::get('/create-computer-test-question',[ComputerTestController::class,'createQuestion']);
    Route::post('/store-computer-test-question',[ComputerTestController::class,'storeQuestion']);

//    Member Management
    Route::get('/member-list',[MemberController::class,'showMemberList']);
    Route::get('/add-member',[MemberController::class,'addMember']);
    Route::post('/store-member',[MemberController::class,'storeMember']);
    Route::get('/edit-member/{id}',[MemberController::class,'editMember']);
    Route::put('/update-member/{id}',[MemberController::class,'updateMember']);

    //Basic computer test
    Route::get('/computer-test/basic/create-mcq-question',[BasicComputerTestController::class,'createMcqQuestion']);
    Route::post('/computer-test/basic/store-mcq-question',[BasicComputerTestController::class,'storeMcqQuestion']);
    Route::get('/computer-test/basic/create-true-false-question',[BasicComputerTestController::class,'createTrueFalseQuestion']);
    Route::post('/computer-test/basic/store-true-false-question',[BasicComputerTestController::class,'storeTrueFalseQuestion']);
    Route::get('/computer-test/basic/create-question-set',[BasicComputerTestController::class,'createQuestionSet']);
    Route::post('/computer-test/basic/store-question-set',[BasicComputerTestController::class,'storeQuestionSet']);


});

Route::get('/member/homepage',[CourseController::class,'index']);
Route::get('/member/course-details/{id}',[CourseController::class,'showCourseDetails']);
Route::get('/member/course/lesson/{lessson_id}',[CourseController::class,'showLesson']);
Route::get('/member/course/quiz/{course_id}',[CourseController::class,'showQuiz']);
Route::get('member/course/pre-quiz/{course_id}',[CourseController::class,'showPreQuiz']);
Route::post('member/course/pre-quiz/{course_id}/submit', [CourseController::class, 'submitPreQuiz'])->name('pre-quiz.submit');
