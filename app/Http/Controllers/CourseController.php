<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Traits\BanglaConverter;


class CourseController extends Controller
{

    use BanglaConverter;

    public function showCourseList(){
        $courses=Course::all();
        return view('course.course-list',compact('courses'));
    }

    public function createCourse(){
        return view ('course.create-course-page');
    }



    public function storeCourse(Request $request){
        // Validate request data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            'target_trainee' => 'required|array',
            'target_trainee.*' => 'in:SI,ASI,SERGEANT,CONSTABLE,ASP,SP,INSPECTOR,INSP,NAIK',
        ]);

        // Find the maximum course_no value in the courses table
        $maxCourseNo = Course::max('course_no');

        // Create the course and set course_no to maxCourseNo + 1
        $course = new Course();
        $course->title = $validated['title'];
        $course->status = $validated['status'];
        $course->target_trainee = implode(',', $validated['target_trainee']);
        $course->course_no = $maxCourseNo + 1;
        $course->save();

        return redirect()->back()->with('success', 'Course created successfully');
    }
    public function editCourse($id){
        $course=Course::find($id);
        if(!$course){
            return redirect()->back()->with('fail','Course does not exist!');
        }
        return view('course.edit-course',compact('course'));
    }

    public function updateCourse(Request $request, $id)
    {
        // Validate the input
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'status' => 'required|in:active,inactive',
            'target_trainee' => 'required|array',
        ]);

        // Find the course by ID
        $course = Course::find($id);

        if (!$course) {
            return redirect()->back()->with('fail', 'Course not found.');
        }

        // Update the course with validated data
        $course->title = $validatedData['title'];
        $course->status = $validatedData['status'];
        $course->target_trainee = implode(',', $validatedData['target_trainee']);
        $course->save();

        return redirect()->back()->with('success', 'Course updated successfully.');
    }

    public function deleteCourse($id)
    {
        $course = Course::find($id);

        if (!$course) {
            return redirect()->back()->with('fail', 'Course not found.');
        }

        $course->delete();
        return redirect()->back()->with('success', 'Course deleted successfully.');
    }


    public function index()
    {
        $member = Auth::guard('member')->user();

        // Fetch all courses applicable to the member
        $courses = DB::table('courses')
            ->where('target_trainee', 'LIKE', '%' . $member->post . '%')
            ->orderBy('course_no', 'ASC')
            ->get();

        // Track the completed courses and their status
        foreach ($courses as $course) {
            // Fetch total lessons for the course
            $totalLessons = DB::table('lessons')
                ->where('courses_id', $course->id_courses)
                ->count();

            // Fetch completed lessons count for the course
            $completedLessonsCount = DB::table('member_lesson_status')
                ->where('member_id', $member->id)
                ->where('course_id', $course->id_courses)
                ->where('status', 'completed')
                ->count();

            // Calculate the completion percentage
            $course->percent = $totalLessons ? ($completedLessonsCount / $totalLessons) * 100 : 0;

            // Mark if the course is fully completed
            $course->completed = $completedLessonsCount === $totalLessons;
        }

        return view('course.index', compact('courses', 'member'));
    }




    public function showCourseDetails($course_id)
    {
        $member = Auth::guard('member')->user();
        $course = DB::table('courses')->where('id_courses', $course_id)->first();

        if (!$course || !in_array($member->post, explode(',', $course->target_trainee))) {
            return redirect()->intended('/member/homepage/');
        }

        // Fetch the lessons in the course
        $lessons = DB::table('lessons')
            ->where('courses_id', $course_id)
            ->orderBy('lesson_no', 'asc')
            ->get();

        $is_complete_course = true;
        $deactive = true;

        // Check the completion status of each lesson
        foreach ($lessons as $lesson) {
            $lessonStatus = DB::table('member_lesson_status')
                ->where('member_id', $member->id)
                ->where('course_id', $course_id)
                ->where('lesson_id', $lesson->id_lessons)
                ->first();

            if (!$lessonStatus || $lessonStatus->status !== 'completed') {
                $is_complete_course = false;
                $deactive = true;
            }
        }

        return view('course.course-details', compact('course', 'lessons', 'deactive', 'is_complete_course', 'member'));
    }



    public function showLesson($lessonId)
    {
        $member = Auth::guard('member')->user();

        // Fetch the lesson along with its materials
        $lesson = Lesson::with('materials')->find($lessonId);

        if (!$lesson) {
            return redirect()->intended('/member/homepage/');
        }

        // Check previous lesson's completion
        $previousLessonStatus = DB::table('member_lesson_status')
            ->where('member_id', $member->id)
            ->where('course_id', $lesson->courses_id)
            ->where('lesson_id', $lesson->lesson_no - 1)
            ->where('status', 'completed')
            ->exists();

        if ($lesson->lesson_no > 1 && !$previousLessonStatus) {
            return redirect()->intended('/member/course-details/' . $lesson->courses_id);
        }

        // Mark this lesson as "completed" in member_lesson_status
        DB::table('member_lesson_status')->updateOrInsert(
            [
                'member_id' => $member->id,
                'course_id' => $lesson->courses_id,
                'lesson_id' => $lesson->id_lessons
            ],
            ['status' => 'completed']
        );

        return view('course.lesson', ['lesson' => $lesson]);
    }



    public function showQuiz($lesson_id)
    {
        $member = Auth::guard('member')->user();

        // Validate lesson ID
        $lesson_id = (int)$lesson_id;


        // Retrieve quiz questions
        $questions = DB::select("SELECT * FROM quiz_questions WHERE lesson_id=?  ORDER BY RAND() LIMIT 10", [$lesson_id]);
        $questions_json = json_encode($questions);

        return view('course.quiz', compact('lesson_id', 'member', 'questions_json'));
    }

    public function updateQuizResult(Request $request)

    {
        $member = Auth::guard('member')->user();
        if ($request->ajax() && $request->input('from') == 'member_panel') {
            $mark = $request->input('mark');
            $lessonId = $request->input('lesson_id');
            $memberId = $member->id;
            $courseId = $request->input('course_id'); // Assuming course_id is provided

            try {
                // Prepare data to insert or update
                $updateData = [
                    'quiz_mark' => $mark,
                    'quiz_status' => 'completed',
                    'updated_at' => now(),
                ];

                // Check if there is already a record for this member, lesson, and course
                $existingStatus = DB::table('member_lesson_status')
                    ->where('member_id', $memberId)
                    ->where('lesson_id', $lessonId)
                    ->where('course_id', $courseId)
                    ->first();

                if ($existingStatus) {
                    // Update the existing record
                    DB::table('member_lesson_status')
                        ->where('member_id', $memberId)
                        ->where('lesson_id', $lessonId)
                        ->where('course_id', $courseId)
                        ->update($updateData);
                } else {
                    // Insert a new record if none exists
                    $updateData['member_id'] = $memberId;
                    $updateData['lesson_id'] = $lessonId;
                    $updateData['course_id'] = $courseId;
                    $updateData['created_at'] = now();

                    DB::table('member_lesson_status')->insert($updateData);
                }

                return response()->json(['status' => 'success', 'msg' => 'Quiz status successfully updated']);
            } catch (\Exception $e) {
                return response()->json(['status' => 'error', 'msg' => 'Could not update quiz status']);
            }
        }

        return response()->json(['status' => 'error', 'msg' => 'Invalid Request']);
    }


}
