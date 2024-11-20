<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Lesson;
class LessonController extends Controller
{

    public function showLessonList(){
        $lessons=Lesson::all();
        return view('course.lesson.lesson-list',compact('lessons'));
    }
public function createLesson(){
    $courses=Course::all();
    return view('course.lesson.add-lesson-page',compact('courses'));
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
        $lesson->update($validated);

        return redirect()->route('admin.lesson.list')->with('success', 'Lesson updated successfully!');
    }
    public function deleteLesson($id)
    {
        // Find the lesson by its ID
        $lesson = Lesson::findOrFail($id);

        // Delete the lesson
        $lesson->delete();

        // Redirect back with success message
        return redirect()->route('admin.lesson.list')->with('success', 'Lesson deleted successfully!');
    }

}
