<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Exam_configuration;
use App\Models\Exam_Schedule;
use App\Models\Member;
use Illuminate\Http\Request;

class ScheduleListController extends Controller
{
    public function index(Request $request)
    {
        $selectedConfigId = $request->input('exam_config_id'); // Get selected configuration ID from request
        $schedule = collect(); // Default to an empty collection
        $examConfigurations = Exam_configuration::all(); // Fetch all configurations for the dropdown

        // If a specific configuration ID is selected, fetch related schedules
        if ($selectedConfigId) {
            $schedule = Exam_Schedule::with(['config', 'member'])
                ->where('exam_config_id', $selectedConfigId)
                ->get()
                ->groupBy('exam_config_id');
        }

        return view('Examschedule.schedule-list', compact('schedule', 'examConfigurations', 'selectedConfigId'));
    }


    public function edit($id)
    {
        $rank = Member::select('post')->distinct()->get();
        $member = Member::all();
        $exam = Exam::all();
        $schedule = Exam_Schedule::where('id', $id)->first();
        return view('edit-schedule', compact('rank', 'member', 'exam', 'schedule'));
    }

    public function update(Request $req)
    {
        $data = array('name' => $req->configuration, 'total_questions' => $req->numques, 'pass_mark' => $req->pmark, 'exam_id' => $req->exam_id, 'date' => $req->date, 'start_time' => $req->stime, 'end_time' => $req->etime, 'status' => 'deactive');
        $config = Exam_configuration::where('name', $req->configuration)->where('exam_id', $req->exam_id)->where('date', $req->date)->where('start_time', $req->stime)->where('end_time', $req->etime)->get();
        if (count($config) == 0) {
            Exam_configuration::create($data);

        }
        $econfig = Exam_configuration::where('name', $req->configuration)->where('exam_id', $req->exam_id)->where('date', $req->date)->where('start_time', $req->stime)->where('end_time', $req->etime)->first();
        $schedule = array('exam_config_id' => $econfig->id, 'password' => random_int(100000, 999999));
        Exam_Schedule::where('id', $req->id)->update($schedule);
        return redirect()->back()->with('success', 'updated successfully');
    }

    public function delete($id)
    {
     Exam_Schedule::where('id',$id)->delete();
     return redirect()->back()->with('fail', 'record deleted');
    }
}
