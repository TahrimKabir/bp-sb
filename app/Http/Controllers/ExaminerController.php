<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ComputerTestHistory;
use App\Models\Exam_Schedule as ExamSchedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ExaminerController extends Controller
{
    public function index()
    {
        $examiner = Auth::guard('web')->user(); // Get the authenticated examiner
        if ($examiner->role === 'examiner') {
            return view('examiner.homepage', ['examiner' => $examiner]); // Examiner homepage view
        }
        return redirect('/'); // Redirect if not examiner
    }

    // Show list of completed exams
    public function showCompletedExams()
    {
         // Fetch completed exams where the exam type is 'advanced computer test'
    $completedExams = ExamSchedule::whereHas('config.exam', function($query) {
        $query->where('type', 'advanced_computer_test');
    })->where('status', 'completed')->get();


        return view('examiner.completed-exams', compact('completedExams'));
    }

    public function evaluateExam($exam_schedule_id)
{
    // Fetch the exam schedule with related data
    $examSchedule = ExamSchedule::with(['config.exam', 'member'])->findOrFail($exam_schedule_id);

    // Fetch all questions from the computer test history for that exam schedule
    $testHistory = ComputerTestHistory::where('exam_schedule_id', $exam_schedule_id)->with('computerTestQuestion')->get();

    return view('examiner.evaluate-page', compact('examSchedule', 'testHistory'));
}
public function submitMarks(Request $request, $examScheduleId)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'marks.*' => 'required|integer|min:0', // Ensure marks are required, integers, and non-negative
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Iterate over each mark entry and update in the database
        foreach ($request->marks as $historyId => $mark) {
            // Find the corresponding test history entry
            $testHistory = ComputerTestHistory::find($historyId);
            if ($testHistory) {
                // Update the marks
                $testHistory->marks = $mark;
                $testHistory->save();

            }
        }

         // After updating all marks, update the `is_evaluated` column in the `exam_schedule` table
    $examSchedule = ExamSchedule::find($examScheduleId); 
    if ($examSchedule) {
        $examSchedule->is_evaluated = 'yes';
        $examSchedule->save();
    }

        return redirect()->back()->with('success', 'Marks successfully updated.');
    }

    public function printResult($id)
{
    $examSchedule = ExamSchedule::with('config.exam', 'member')->findOrFail($id);
    $testHistory = ComputerTestHistory::where('exam_schedule_id', $id)->get();
    
    return view('examiner.print_result', compact('examSchedule', 'testHistory'));
}

}