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

    public function addMaterials(){
        $lessons=Lesson::all();
        return view('course.add-materials-page',compact('lessons'));
    }

    public function storeMaterial(Request $request)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id_lessons',
            'materials.*.material_type' => 'required|in:pdf,audio,video,link',
            'materials.*.material_name' => 'nullable|string|max:255',
        ]);

        // Custom validation for `material_url` depending on `material_type`
        foreach ($request->materials as $key => $material) {
            if ($material['material_type'] === 'link') {
                if (!isset($material['material_url']) || !filter_var($material['material_url'], FILTER_VALIDATE_URL)) {
                    return redirect()->back()
                        ->withErrors(["materials.$key.material_url" => 'The material URL must be a valid URL.'])
                        ->withInput();
                }
            } else {
                if (!$request->hasFile("materials.$key.material_url")) {
                    return redirect()->back()
                        ->withErrors(["materials.$key.material_url" => 'The material URL must be a file.'])
                        ->withInput();
                }

                $file = $request->file("materials.$key.material_url");
                if (!in_array($file->getClientOriginalExtension(), ['pdf', 'mp3', 'mp4'])) {
                    return redirect()->back()
                        ->withErrors(["materials.$key.material_url" => 'The material URL must be a file of type: pdf, mp3, or mp4.'])
                        ->withInput();
                }
            }
        }

        // Save materials
        foreach ($request->materials as $key => $materialData) {
            $material = new Material();
            $material->lesson_id = $request->lesson_id;
            $material->material_type = $materialData['material_type'];
            $material->material_name = $materialData['material_name'] ?? null;

            if ($materialData['material_type'] !== 'link') {
                $file = $request->file("materials.$key.material_url");
                $filePath = $file->store('materials', 'public');
                $material->material_url = $filePath;
            } else {
                $material->material_url = $materialData['material_url'];
            }

            $material->save();
        }

        return redirect()->back()->with('success', 'Materials added successfully!');
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

        // Check if the material type is not 'link' and the file exists in storage
        if ($material->material_type !== 'link' && $material->material_url) {
            // Use Laravel's Storage facade to delete the file
            if (Storage::disk('public')->exists($material->material_url)) {
                Storage::disk('public')->delete($material->material_url);
            }
        }


        $material->delete();

        return redirect()->route('admin.materials')
            ->with('success', 'Material deleted successfully.');
    }
}
