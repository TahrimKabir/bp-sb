<?php

use App\Http\Controllers\BasicComputerTestController;
use App\Http\Controllers\ComputerTestController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseListController;
use App\Http\Controllers\CourseMaterialController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ExamListController;
use App\Http\Controllers\IqTestController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuestionListController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ScheduleListController;
use App\Http\Controllers\TypingTestController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExaminerController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

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
Route::group(['middleware' => ['auth']], function () {
//    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/course-list', [CourseListController::class, 'index']);
    Route::get('/admin/change-password', [AdminController::class, 'changePassword'])->name('admin.change_password');
    Route::post('/admin/update-password', [AdminController::class, 'updatePassword'])->name('admin.update_password');

// Route::post('/schedule-created',[ScheduleController::class,'update'])->name('schedule-created');
    Route::get('/create-question', [QuestionController::class, 'index']);
    Route::post('/question-created', [QuestionController::class, 'store'])->name('question-created');

// Route::get('/generate-certificate/{id}', [CertificateController::class, 'generateCertificate']);
//IQ test//////////
    Route::get('/questionlist', [QuestionListController::class, 'index']);
    Route::get('/questionlist-chunk', [QuestionListController::class, 'indexList']);
    Route::get('/edit/question/{id}', [QuestionListController::class, 'edit']);
    Route::post('/question-updated', [QuestionListController::class, 'update'])->name('question-updated');
    Route::get('/delete/question/{id}', [QuestionListController::class, 'delete']);
    Route::get('iq-test/result/{id}', [IqTestController::class, 'showResult'])->name('iq-test.result');

// exam
    Route::get('/create-exam', [ExamController::class, 'index']);
    Route::post('/exam-added', [ExamController::class, 'store'])->name('store-exam');
// exam-list
    Route::get('/exam-list', [ExamListController::class, 'index']);
    Route::get('/exam-list-chunk', [ExamListController::class, 'indexList']);
    Route::get('/edit/exam/{id}', [ExamListController::class, 'edit']);
    Route::post('/exam-updated', [ExamListController::class, 'update'])->name('update-exam');
    Route::get('/delete/exam/{id}', [ExamListController::class, 'delete']);


//exam schedule////
    Route::get('/create-schedule', [ScheduleController::class, 'createSchedule']);
    Route::post('/schedule-created', [ScheduleController::class, 'store'])->name('store-schedule');
    Route::get('/add-member-to-schedule/{configurationID}', [ScheduleController::class, 'showAddMembersForm']);
    Route::post('/store-member-to-schedule', [ScheduleController::class, 'addMembers']);
    Route::get('/schedule-list', [ScheduleListController::class, 'index'])->name('schedule.index');
    Route::get('/edit/schedule/{id}', [ScheduleListController::class, 'edit']);
    Route::post('/schedule-updated', [ScheduleListController::class, 'update'])->name('update-schedule');
    Route::get('/delete/schedule/{id}', [ScheduleListController::class, 'delete']);

    //typing test questions
    Route::get('/typing-test-question-list', [TypingTestController::class, 'showQuestionList']);
    Route::get('/typing-test-question-list-chunk', [TypingTestController::class, 'showQuestionListChunk']);
    Route::get('/create-typing-test-question', [TypingTestController::class, 'createQuestion']);
    Route::post('/store-typing-test-question', [TypingTestController::class, 'storeQuestion']);
    Route::get('/edit-typing-test-question/{id}', [TypingTestController::class, 'editQuestion']);
    Route::post('/update-typing-test-question', [TypingTestController::class, 'updateQuestion']);
    Route::delete('/delete-typing-test-question/{id}', [TypingTestController::class, 'deleteQuestion']);


    //Computer Test Questions
    Route::get('/computer-test-question-list', [ComputerTestController::class, 'showQuestionSetList']);
    Route::get('/computer-test-question-list-chunk', [ComputerTestController::class, 'showQuestionSetListChunk']);
    Route::get('/create-computer-test-question', [ComputerTestController::class, 'createQuestion']);
    Route::post('/store-computer-test-question', [ComputerTestController::class, 'storeQuestion']);

//    Member Management
    Route::get('/member-list', [MemberController::class, 'showMemberList']);
    Route::get('/member-list-chunk', [MemberController::class, 'showMemberListChunk']);
    Route::get('/add-member', [MemberController::class, 'addMember']);
    Route::post('/store-member', [MemberController::class, 'storeMember']);
    Route::post('/store-bulk-member', [MemberController::class, 'storeBulkMember']);
    Route::get('/edit-member/{id}', [MemberController::class, 'editMember']);
    Route::put('/update-member/{id}', [MemberController::class, 'updateMember']);
    Route::get('/delete-member/{id}', [MemberController::class, 'deleteMember']);

    //Basic computer test

    //mcq////
    Route::get('/computer-test/basic/create-mcq-question', [BasicComputerTestController::class, 'createMcqQuestion']);
    Route::post('/computer-test/basic/store-mcq-question', [BasicComputerTestController::class, 'storeMcqQuestion']);
    Route::get('/computer-test/basic/mcq-question-list', [BasicComputerTestController::class, 'mcqQuestionList']);
    Route::get('/computer-test/basic/mcq-question-edit/{id}', [BasicComputerTestController::class, 'editMcqQuestion']);
    Route::put('/computer-test/basic/mcq-question-update/{question}', [BasicComputerTestController::class, 'updateMcqQuestion'])->name('mcq.update');
    Route::delete('/computer-test/basic/mcq-question-delete/{id}', [BasicComputerTestController::class, 'mcqQuestionDelete']);

    //true false questions
    Route::get('/computer-test/basic/create-true-false-question', [BasicComputerTestController::class, 'createTrueFalseQuestion']);
    Route::post('/computer-test/basic/store-true-false-question', [BasicComputerTestController::class, 'storeTrueFalseQuestion']);
    Route::get('/computer-test/basic/true-false-question-list', [BasicComputerTestController::class, 'trueFalseQuestionList']);
    Route::get('computer-test/basic/edit-true-false-question/{id}', [BasicComputerTestController::class, 'editTrueFalseQuestion']);
    Route::put('computer-test/basic/update-true-false-question/{id}', [BasicComputerTestController::class, 'updateTrueFalseQuestion']);
    Route::delete('/computer-test/basic/true-false-question-delete/{id}', [BasicComputerTestController::class, 'trueFalseQuestionDelete']);

    //question sets
    Route::get('/computer-test/basic/create-question-set', [BasicComputerTestController::class, 'createQuestionSet']);
    Route::post('/computer-test/basic/store-question-set', [BasicComputerTestController::class, 'storeQuestionSet']);
    Route::get('/computer-test/basic/question-set-list', [BasicComputerTestController::class, 'showQuestionSetList']);
    Route::get('/computer-test/basic/question-set-list-chunk', [BasicComputerTestController::class, 'showQuestionSetListChunk']);
    Route::get('/computer-test/basic/question-set-edit/{id}', [BasicComputerTestController::class, 'editQuestionSet'])->name('basic-question-set.edit');
    Route::delete('/computer-test/basic/question-set-delete/{id}', [BasicComputerTestController::class, 'deleteQuestionSet']);

    Route::put('question-set/{id}', [BasicComputerTestController::class, 'updateQuestionSet'])->name('basic-question-set.update');


    Route::get('/computer-test/basic/result/{id}', [BasicComputerTestController::class, 'showResult'])->name('basic-computer-test.result');


///Course Management

    Route::get('/admin/create-course', [CourseController::class, 'createCourse']);
    Route::post('/admin/store-course', [CourseController::class, 'storeCourse'])->name('courses.store');
    Route::get('/admin/course-list', [CourseController::class, 'showCourseList']);
    Route::get('/admin/course-list-chunk', [CourseController::class, 'showCourseListChunk']);
    Route::get('/edit-course/{id}', [CourseController::class, 'editCourse'])->name('course.edit');
    Route::post('/update-course/{id}', [CourseController::class, 'updateCourse'])->name('course.update');
    Route::delete('/delete-course/{id}', [CourseController::class, 'deleteCourse'])->name('course.delete');

    Route::get('/get-file', function (Request $request) {
        $path = storage_path('app/public/' . $request->filename);

        if (!file_exists($path)) {
            abort(404);
        }

        // Get the file's content and MIME type
        $file = file_get_contents($path);
        $type = mime_content_type($path);

        // Return the file as a response
        return Response::make($file, 200)->header("Content-Type", $type);
    })->name('get.storage.file');

    ///materials management
    Route::get('admin/add-materials/{lesson_id}', [CourseMaterialController::class, 'addMaterial']);
    Route::post('/admin/store-materials', [CourseMaterialController::class, 'storeMaterial'])->name('admin.store.materials');
    Route::get('/admin/material-list', [CourseMaterialController::class, 'showMaterialList'])->name('admin.materials');
    Route::delete('/admin/delete-materials/{id}', [CourseMaterialController::class, 'deleteMaterial'])->name('admin.materials.destroy');


///lesson management

    Route::get('/admin/create-lesson/{courseId?}', [LessonController::class, 'createLesson']);
    Route::post('/admin/store-lesson', [LessonController::class, 'storeLesson'])->name('lessons.store');
    Route::get('admin/lesson-list/{courseId?}', [LessonController::class, 'showLessonList'])->name('admin.lesson.list');
    Route::delete('/delete-lesson/{id}', [LessonController::class, 'deleteLesson'])->name('lesson.delete');
    Route::get('admin/edit-lesson/{id}', [LessonController::class, 'editLesson'])->name('lesson.edit');
    Route::put('admin/update-lesson/{id}', [LessonController::class, 'updateLesson'])->name('lesson.update');
    Route::get('admin/lessons', [LessonController::class, 'getLessons'])->name('admin.materials.getLessons');
    /// Quiz Question management
    Route::get('admin/create-quiz-question/{lessonId}', [QuizController::class, 'createQuestion']);
    Route::post('/admin/store-quiz-question', [QuizController::class, 'storeQuestion'])->name('quiz-question-store');
    Route::get('/admin/quiz-question-list/{lesson_id}', [QuizController::class, 'quizQuestionList'])->name('quiz-question-list');
    Route::get('/admin/quiz-question-list-chunk/{lesson_id}', [QuizController::class, 'quizQuestionListChunk'])->name('quiz-question-list-chunk');
    Route::get('admin/edit-quiz-question/{id}', [QuizController::class, 'editQuizQuestion']);
    Route::put('admin/update-quiz-question/{id}', [QuizController::class, 'updateQuizQuestion'])->name('quiz-question-update');
    Route::delete('admin/delete-quiz-question/{id}', [QuizController::class, 'deleteQuizQuestion'])->name('quiz-question.delete');

});

Route::middleware(['auth', 'super_admin'])->group(function () {
    Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/admin/store', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('/admin/update/{id}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin/remove/{id}', [AdminController::class, 'remove'])->name('admin.remove');
});


//examiner////////////
Route::group(['middleware' => ['auth', 'examiner']], function () {

    Route::get('/examiner/homepage', [ExaminerController::class, 'index'])->name('examiner.homepage');
    Route::get('/examiner/completed-exams', [ExaminerController::class, 'showCompletedExams'])->name('examiner.completed-exams');
    Route::get('/examiner/evaluate-exam/{exam_schedule_id}', [ExaminerController::class, 'evaluateExam'])->name('examiner.evaluate-exam');
    Route::post('/examiner/submit-evaluation/{exam_schedule_id}', [ExaminerController::class, 'submitMarks'])->name('examiner.submit-evaluation');


});
Route::get('/examiner/print-exam-result/{id}', [ExaminerController::class, 'printResult'])->name('examiner.print-exam-result');


Route::get('/member/homepage', [CourseController::class, 'index']);
Route::get('/member/course-details/{id}', [CourseController::class, 'showCourseDetails']);
Route::get('/member/course/lesson/{lessson_id}', [CourseController::class, 'showLesson']);
Route::get('/member/course/quiz/{course_id}', [CourseController::class, 'showQuiz']);
Route::post('/member/quiz-result-update', [CourseController::class, 'updateQuizResult'])->name('quiz-result-update');

Route::get('member/course/pre-quiz/{course_id}', [CourseController::class, 'showPreQuiz']);
Route::post('member/course/pre-quiz/{course_id}/submit', [CourseController::class, 'submitPreQuiz'])->name('pre-quiz.submit');

