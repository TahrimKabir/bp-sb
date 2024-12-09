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
        $courses=[];
        return view('course.course-list',compact('courses'));
    }

    public function showCourseListChunk(Request $request)
    {
        // Extract the DataTable parameters
        $start = $request->input('start', 0); // Starting row
        $length = $request->input('length', 10); // Number of rows to fetch
        $searchValue = $request->input('search.value'); // Search value (if any)
        $orderColumnIndex = $request->input('order.0.column'); // Column index for sorting
        $orderDirection = $request->input('order.0.dir', 'asc'); // Sorting direction

        // Define sortable columns
        $columns = ['id_courses', 'title', 'course_no', 'status', 'target_trainee', ]; // Adjust column names to match your table
        $orderColumn = $columns[$orderColumnIndex] ?? 'question_id';

        // Query the database
        $query = Course::query();

        // Apply search filter
        if ($searchValue) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('title', 'like', "%$searchValue%")
                  ->orWhere('course_no', 'like', "%$searchValue%")
                  ->orWhere('status', 'like', "%$searchValue%")
                  ->orWhere('target_trainee', 'like', "%$searchValue%");
            });
        }

        // Get total count before applying pagination
        $totalRecords = $query->count();

        // Apply sorting and pagination
        $data = $query->orderBy($orderColumn, $orderDirection)
                      ->skip($start)
                      ->take($length)
                      ->get();

        // Append action column
        $data->transform(function ($item, $index) use ($start) {
            $item->serial = $start + $index + 1;
            $item->status = ucfirst($item->status);
            $item->target_trainee = str_replace(',', ', ', $item->target_trainee);

            // Add action buttons: Edit, Delete, and Show Lessons
            $item->action = '<div class="col-12 d-flex justify-content-center">
                        <button type="button" class="btn btn-xs btn-danger" onclick="confirmDelete(' . $item->id_courses . ')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
                                <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5zm13-3H1v2h14zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                            </svg>
                        </button>
                        <a href="' . url('/edit-course/' . $item->id_courses) . '" class="btn btn-warning btn-xs ml-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                            </svg>
                        </a>
                        <a href="' . url('admin/lesson-list/' . $item->id_courses) . '" class="btn btn-info btn-xs ml-1">Show Lessons</a>
                    </div>';
            return $item;
        });

        // Return response in DataTable-compatible format
        return response()->json([
            'draw' => $request->input('draw'), // Pass through DataTables draw parameter
            'recordsTotal' => $totalRecords, // Total records without filtering
            'recordsFiltered' => $totalRecords, // Total records after filtering
            'data' => $data, // Paginated data
        ]);
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
            'target_trainee.*' => 'in:SI,ASI,SERGEANT,CONSTABLE,ASP,SP,INSPECTOR,INSP,NAIK,ATSI,Add. SP,ADD-DIG',
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

        $courses = DB::table('courses')
            ->whereRaw("FIND_IN_SET(?, target_trainee)", [$member->post])
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
