<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Lesson;
class LessonController extends Controller
{


    public function getLessons(Request $request)
    {
        $courseId = $request->input('course_id');
        $lessons = Lesson::where('courses_id', $courseId)->get();

        return response()->json([
            'lessons' => $lessons
        ]);
    }
    public function showLessonList($courseId = null)
    {
        // If course_id is provided, fetch lessons for that course, otherwise fetch all lessons
        $lessons = $courseId
            ? Lesson::where('courses_id', $courseId)->get()
            : Lesson::all();

        return view('course.lesson.lesson-list', compact('lessons', 'courseId'));
    }


    public function createLesson($courseId)
    {
        $course = Course::findOrFail($courseId); // Ensure the course exists
        return view('course.lesson.add-lesson-page', compact('course'));
    }


    public function storeLesson(Request $request)

    {
        $request->validate([
            'courses_id' => 'required|exists:courses,id_courses',
            'title' => 'required|string|max:255',

        ]);

        // Determine the next lesson number for the specified course
        $nextLessonNo = Lesson::where('courses_id', $request->courses_id)->max('lesson_no') + 1;

        Lesson::create([
            'courses_id' => $request->courses_id,
            'title' => $request->title,

            'lesson_no' => $nextLessonNo,

        ]);

        return redirect()->back()->with('success', 'Lesson added successfully!');
    }


    public function editLesson($id)
    {
        $lesson = Lesson::findOrFail($id);
        $courses = Course::all();  // Get all available courses for the dropdown
        return view('course.lesson.edit-lesson', compact('lesson', 'courses'));
    }

    public function updateLesson(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'courses_id' => 'required|exists:courses,id_courses',
        ]);

        $lesson = Lesson::findOrFail($id);

        // Update the lesson with validated data
        $lesson->update($validated);

        // Redirect to the lesson list with the courseId of the updated lesson
        return redirect()->route('admin.lesson.list', ['courseId' => $lesson->courses_id])
            ->with('success', 'Lesson updated successfully!');
    }

    public function deleteLesson($id)
    {
        // Find the lesson by its ID
        $lesson = Lesson::findOrFail($id);

        // Retrieve the course ID before deleting the lesson
        $courseId = $lesson->courses_id;

        // Delete the lesson
        $lesson->delete();

        // Redirect to the lesson list with the courseId of the deleted lesson
        return redirect()->route('admin.lesson.list', ['courseId' => $courseId])
            ->with('success', 'Lesson deleted successfully!');
    }


}
