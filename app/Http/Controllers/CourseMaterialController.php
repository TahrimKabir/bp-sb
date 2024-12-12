<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseMaterialController extends Controller
{

    public function addMaterial($lesson_id)
    {
        $lesson = Lesson::find($lesson_id);

        if (!$lesson) {
            return redirect()->back()->with('fail', 'Lesson not found.');
        }

        return view('course.add-materials-page', compact('lesson'));
    }



    public function storeMaterial(Request $request)
    {
        // Validate the lesson ID and material type
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id_lessons',
            'material_type' => 'required|in:pdf,audio,video,link',
            'material_name' => 'nullable|string|max:255',
        ]);

        // Conditional validation for `material_url`
        if ($request->material_type === 'link') {
            $request->validate([
                'material_url' => 'required|string|url',
            ]);
        } else {
            $request->validate([
                'material_url' => 'required|file',
            ]);

            // Validate file extension based on the material type
            $file = $request->file('material_url');
            $allowedExtensions = match ($request->material_type) {
                'pdf' => ['pdf'],
                'audio' => ['mp3', 'wav', 'aac'],
                'video' => ['mp4', 'avi', 'mkv'],
                default => []
            };

            if (!in_array($file->getClientOriginalExtension(), $allowedExtensions)) {
                return redirect()->back()
                    ->withErrors(['material_url' => 'The material must be a valid file type for the selected material type.'])
                    ->withInput();
            }

            // Store the file
            $filePath = $file->store('materials', 'public');
        }

        // Save material to the database
        $material = new Material();
        $material->lesson_id = $request->lesson_id;
        $material->material_type = $request->material_type;
        $material->material_name = $request->material_name ?? null;

        if ($request->material_type === 'link') {
            $material->material_url = $request->material_url;
        } else {
            $material->material_url = $filePath;
        }

        $material->save();
        return redirect()->to('admin/material-list?lesson_filter='.$material->lesson_id)
            ->with('success', 'Material Added successfully.');
    }






    public function showMaterialList(Request $request)
    {

        $selectedCourseId = $request->get('course_filter', '');
        $selectedLessonId = $request->get('lesson_filter', '');

        // Get all courses for the dropdown
        $courses = Course::all();

        // Get lessons filtered by course and lesson filters, eager load materials
        $lessonsQuery = Lesson::query();

        // Filter lessons by course
        if ($selectedCourseId) {
            $lessonsQuery->where('courses_id', $selectedCourseId);
        }

        // Filter lessons by selected lesson if it's set
        if ($selectedLessonId) {
            $lessonsQuery->where('id_lessons', $selectedLessonId);
        }

        // Eager load the materials for each lesson
        $lessons = $lessonsQuery->with('materials')->get();

        // Pass necessary data to the view

        return view('course.material-list', compact('lessons', 'courses', 'selectedCourseId', 'selectedLessonId'));
    }




    public function deleteMaterial($id)
    {
        $material = Material::findOrFail($id);
$lessonId=$material->lesson_id;
        // Check if the material type is not 'link' and the file exists in storage
        if ($material->material_type !== 'link' && $material->material_url) {
            // Use Laravel's Storage facade to delete the file
            if (Storage::disk('public')->exists($material->material_url)) {
                Storage::disk('public')->delete($material->material_url);
            }
        }



        $material->delete();

        return redirect()->to('admin/material-list?lesson_filter='.$lessonId)
            ->with('success', 'Material deleted successfully.');
    }
}
