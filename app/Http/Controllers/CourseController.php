<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Traits\BanglaConverter;

class CourseController extends Controller
{

    use BanglaConverter;
    public function index(){


        $member = Auth::guard('member')->user();
        $courses = DB::select("SELECT * FROM courses WHERE target_trainee LIKE '%".$member->post."%' ORDER BY course_no ASC");
        $completed_course = DB::select("SELECT * FROM members_course_status WHERE member_id = ? AND course_status = 'complete'", [$member->id]);


        $completed_course_ids = array_map(function ($course) {
            return $course->course_id;
        }, $completed_course);


        foreach ($courses as &$course) {

            $total_lessons_result = DB::select("SELECT COUNT(*) as total FROM lessons WHERE courses_id = ?", [$course->id_courses]);
            $total_lessons = $total_lessons_result[0]->total + 3;
            if ($course->id_courses == 3) {
                $total_lessons -= 2;
            }


            $completed_lessons_result = DB::select("SELECT (pre_evalution + exam + post_evalution + lesson_1 + lesson_2 + lesson_3 + lesson_4 + lesson_5 + lesson_6 + lesson_7 + lesson_8) as total FROM members_course_status WHERE member_id = ? AND course_id = ?", [$member->id, $course->id_courses]);


            if (empty($completed_lessons_result)) {
                $completed_lessons = 0;

            }
            else{
                $completed_lessons = $completed_lessons_result[0]->total;
            }


            if ($course->id_courses == 3  ) {
                $completed_lessons -= 2;
            }


            $percent = round($completed_lessons / $total_lessons * 100);


            $course->percent = $percent;
            $course->completed = in_array($course->id_courses, $completed_course_ids);
        }
        return view('course.index',compact('courses','member','completed_course'));
    }


    public function showCourseDetails($course_id)
    {
        $member = Auth::guard('member')->user();

        $course_id = (int) $course_id;

        $course = DB::table('courses')->where('id_courses', $course_id)->first();

        if (!$course || !in_array($member->post, explode(',', $course->target_trainee))) {
            return redirect()->intended('/member/homepage/');
        }

        $course_status = DB::table('members_course_status')
            ->where('member_id', $member->id)
            ->where('course_id', $course_id)
            ->first();

        $lessons = DB::table('lessons')
            ->where('courses_id', $course_id)
            ->orderBy('lesson_no', 'asc')
            ->get();

        $deactive = $course_status && $course_status->pre_evalution ? false : true;
        $is_complete_course = true;

        foreach ($lessons as $lesson) {
            if ($course_status && !$course_status->{'lesson_' . $lesson->lesson_no}) {
                $deactive = true;
                $is_complete_course = false;
            }
        }

        return view('course.course-details', compact('course', 'course_status', 'lessons', 'deactive', 'is_complete_course','member'));
    }


    public function showLesson($lessonId)
    {
        $member = Auth::guard('member')->user();

        // Check if lessonId is provided and valid
        if (isset($lessonId) && $lessonId > 0) {
            // Fetch the lesson from the database
            $lesson = DB::table('lessons')->where('id_lessons', $lessonId)->first();

            // Check if the lesson exists
            if ($lesson) {
                // Check if the lesson blade file exists
                $lessonFilePath = "course.lessons.lesson_id_" . $lessonId;
                if (view()->exists($lessonFilePath)) {
                    // Fetch course status from members_course_status table
                    $courseStatus = DB::table('members_course_status')
                        ->where('member_id', $member->id)
                        ->where('course_id', $lesson->courses_id)
                        ->first();

                    // Redirect to course details page if required
                    if ($lesson->lesson_no == 1 && (!$courseStatus || !$courseStatus->pre_evalution)) {
                        return redirect()->intended('/member/course-details/' . $lesson->courses_id);
                    } elseif ($lesson->lesson_no > 1 && (!$courseStatus || !$courseStatus->{'lesson_' . ($lesson->lesson_no - 1)})) {
                        return redirect()->intended('/member/course-details/' . $lesson->courses_id);
                    }

                    // Update course status in members_course_status table if necessary
                    if ($lesson->courses_id == 3 && $courseStatus && $courseStatus->course_status == 'unseen') {
                        DB::table('members_course_status')
                            ->where('id_members_course_status', $courseStatus->id_members_course_status)
                            ->update([
                                'lesson_' . $lesson->lesson_no => 1,
                                'course_status' => 'continue',
                                'started_at' => now(),
                            ]);
                    } elseif ($courseStatus) {
                        DB::table('members_course_status')
                            ->where('id_members_course_status', $courseStatus->id_members_course_status)
                            ->update(['lesson_' . $lesson->lesson_no => 1]);
                    }

                    // Load the lesson view
                    return view($lessonFilePath, ['lesson' => $lesson]);
                } else {
                    // Lesson blade file does not exist
                    return redirect()->intended('/member/homepage/');
                }
            }
        }

        // Invalid lesson ID or lesson not found
        return redirect()->intended('/member/homepage/');
    }


//    public function showQuiz($course_id)
//    {
//        $member = Auth::guard('member')->user();
//
//        // Validate course ID
//        $course_id = (int)$course_id;
//
//        // Retrieve course status
//        $course_status = DB::select("SELECT id_members_course_status, course_id, exam FROM members_course_status WHERE member_id=? AND course_id=? LIMIT 1", [$member->id, $course_id]);
//
//        // Retrieve total number of lessons
//        $total_lesson_result = DB::select("SELECT COUNT(*) as total FROM lessons WHERE courses_id=?", [$course_id]);
//        $total_lesson = $total_lesson_result[0]->total;
//
//        // Retrieve completed lessons
//        $complete_lesson_result = DB::select("SELECT (lesson_1+lesson_2+lesson_3+lesson_4+lesson_5+lesson_6+lesson_7+lesson_8) as total FROM members_course_status WHERE member_id=? AND course_id=?", [$member->id_members, $course_id]);
//        $complete_lesson = $complete_lesson_result[0]->total;
//
//        // Redirect if course status does not meet requirements
//        if (empty($course_status) || $course_status[0]->exam || $complete_lesson != $total_lesson) {
//            return redirect()->route('course.details', ['course_id' => $course_id]);
//        }
//
//        // Retrieve course information
//        $course_info = DB::select("SELECT title, target_trainee FROM courses WHERE id_courses=? LIMIT 1", [$course_id]);
//        $course = $course_info[0];
//        $target_trainee = explode(",", $course->target_trainee);
//
//        // Redirect if member's post is not in target trainee
//        if (!in_array($member->post, $target_trainee)) {
//            return redirect()->route('index');
//        }
//
//        // Retrieve quiz questions
//        $questions = DB::select("SELECT * FROM questions WHERE course_id=? AND qus_cat='quiz' ORDER BY RAND() LIMIT 10", [$course_id]);
//        $questions_json = json_encode($questions);
//
//        return view('course.quiz', compact('course_id', 'member', 'course', 'questions_json'));
//    }


    public function showPreQuiz($course_id)
    {

        $member = Auth::guard('member')->user();

        $course = DB::table('courses')->where('id_courses', $course_id)->first();

        if (!$course) {
            return redirect()->intended('/member/homepage/');
        }

        $courseStatus = DB::table('members_course_status')
            ->where('member_id', $member->id)
            ->where('course_id', $course_id)
            ->first();

        if (!$courseStatus) {
            return redirect()->intended('/member/course-details/' . $course_id);
        }

        if ($courseStatus->pre_evalution) {
            $lesson = DB::table('lessons')->where('course_id', $course_id)->orderBy('lesson_no')->first();

            return redirect()->intended('/member/course/lesson/' .$lesson->id_lessons);
        }

        $radioQuestions = DB::table('questions')
            ->where('qus_cat', 'like', '%pre_evaluation%')
            ->where('ques_type', 'radio')
            ->get();

        $checkboxQuestions = DB::table('questions')
            ->where('qus_cat', 'like', '%pre_evaluation%')
            ->where('ques_type', 'checkbox')
            ->get();

        return view('course.pre_quiz', compact('course_id', 'course', 'courseStatus', 'radioQuestions', 'checkboxQuestions'));
    }

    public function submitPreQuiz(Request $request, $course_id)
    {
        $member = Auth::guard('member')->user();

        // Validate the form submission
        $request->validate([
            // Validation rules for the form fields
        ]);

        // Process form submission and save survey data
        $status_table_id = DB::table('members_course_status')
            ->where('member_id', $member->id)
            ->where('course_id', $course_id)
            ->value('id_members_course_status');

        $group_a = json_encode($request->input('answer1'));
        $group_b = json_encode($request->input('answer2'));

        DB::table('survey')->insert([
            'member_id' => $member->id,
            'status_table_id' => $status_table_id,
            'evaluation_type' => 'pre',
            'group_a' => $group_a,
            'group_b' => $group_b,
            'created_at' => now(),
        ]);

        // Update course status to mark pre-evaluation as completed
        DB::table('members_course_status')
            ->where('id_members_course_status', $status_table_id)
            ->update([
                'pre_evalution' => 1,
                'course_status' => 'continue',
                'started_at' => now(),
            ]);

        // Redirect to the next lesson or page
        $lesson = DB::table('lessons')->where('courses_id', $course_id)->orderBy('lesson_no')->first();
        return redirect()->intended('/member/course/lesson/' . $lesson->id_lessons);
    }

}
