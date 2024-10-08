<?php

namespace App\Http\Controllers;

use App\Models\Exam_Schedule as ExamSchedule;

use App\Models\Result;
use Illuminate\Http\Request;

class IqTestController extends Controller
{
    public function showResult($examScheduleId){

        $examSchedule = ExamSchedule::with(['config.exam', 'member'])->findOrFail($examScheduleId);
        $result = Result::where('exam_schedule_id', $examScheduleId)->first();;
        return view('iqTest.result-page', compact('result','examSchedule'));
    }


}
