<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Exam_configuration;
use App\Models\Exam_Schedule;
use App\Models\Member;
use App\Models\QuestionSet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScheduleListController extends Controller
{
    public function index()
    {
        // Fetch all configurations
        $examConfigurations = Exam_configuration::with('exam')->get();

        return view('Examschedule.index', compact('examConfigurations'));
    }

    public function show($id)
    {
        $examConfiguration = Exam_configuration::with('exam')->findOrFail($id);
        $schedules = Exam_Schedule::where('exam_config_id', $id)->with('member')->get();

        return view('Examschedule.schedule-list', compact('examConfiguration', 'schedules'));
    }

//    public function index(Request $request)
//    {
//        $selectedConfigId = $request->input('exam_config_id'); // Get selected configuration ID from request
//        $schedule = collect(); // Default to an empty collection
//        $examConfigurations = Exam_configuration::all(); // Fetch all configurations for the dropdown
//
//        // If a specific configuration ID is selected, fetch related schedules
//        if ($selectedConfigId) {
//            $schedule = Exam_Schedule::with(['config', 'member'])
//                ->where('exam_config_id', $selectedConfigId)
//                ->get()
//                ->groupBy('exam_config_id');
//        }
//
//        return view('Examschedule.schedule-list', compact('schedule', 'examConfigurations', 'selectedConfigId'));
//    }


    public function edit($id)
    {
        // Fetch the schedule data by ID
        $examConfiguration = Exam_configuration::findOrFail($id);

        // Fetch exam data for dropdown
        $exam = Exam::all();

        // Fetch advanced and basic question sets
        $advancedQuestionSets = QuestionSet::where('type', 'advanced')->get();
        $basicQuestionSets = QuestionSet::where('type', 'basic')->get();

        // Pass data to the view
        return view('Examschedule.edit-schedule', compact('examConfiguration', 'exam', 'advancedQuestionSets', 'basicQuestionSets'));
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'total_questions' => 'nullable|integer|min:1',
            'pass_mark' => 'nullable|numeric|min:0',
            'exam_id' => 'required|exists:exams,exam_id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'question_set_id' => 'nullable|exists:question_sets,question_set_id',

        ]);

        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Find the exam configuration
        $examConfiguration = Exam_configuration::find($id);

        if (!$examConfiguration) {
            return redirect()->back()->with('error', 'Exam configuration not found.');
        }


        $examConfiguration->update([
            'name' => $request->input('name'),
            'total_questions' => $request->input('total_questions'),
            'pass_mark' => $request->input('pass_mark'),
            'exam_id' => $request->input('exam_id'),
            'date' => $request->input('date'),
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
            'question_set_id' => $request->input('question_set_id'),

        ]);

        return redirect()->back()->with('success', 'Exam schedule updated successfully.');
    }

    public function delete($id)
    {
     Exam_Schedule::where('id',$id)->delete();
     return redirect()->back()->with('fail', 'record deleted');
    }

    public function deleteConfiguration($id)
    {
        try {
            $examConfig = Exam_configuration::findOrFail($id); // Find the schedule by its ID
            $examConfig->delete(); // Delete the record

            return redirect()->back()->with('success', 'Exam Schedule deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('fail', 'Failed to delete the exam schedule.');
        }
    }
}
