<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExamController extends Controller
{
    public function index()
    {
        $course = Course::all();
        return view('create-exam', compact('course'));
    }

    public function store(Request $request)
    {
        // Define validation rules
        $rules = [
            'exam' => 'required|string',

            'type' => 'required|string',
            'details' => 'required|string',
        ];

        // Define custom error messages
        $messages = [
            'exam.required' => 'The exam title is required.',
            'exam.string' => 'The exam title must be a string.',

            'type.required' => 'The exam type is required.',
            'type.string' => 'The exam type must be a string.',
            'details.required' => 'The exam details are required.',
            'details.string' => 'The exam details must be a string.',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules, $messages);

        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            dd('Validation failed:', $validator->errors()->all());

        }

        // Check if the exam/course/type already exists
        $existingExam = Exam::where('exam_name', $request->exam)
            ->where('type', $request->type)

            ->exists();

        if ($existingExam) {
            return redirect()->back()->with('fail', 'Could not create new exam as it already exists.');
        }

        // Create the exam if it doesn't exist
        Exam::create([
            'exam_name' => $request->exam,

            'type' => $request->type,
            'details' => $request->details,
            'status' => 'deactive',
        ]);

        return redirect()->back()->with('success', 'Exam added successfully');

}
}
