<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Exam_configuration;
use App\Models\Exam_Schedule;
use App\Models\Member;
use App\Models\Result;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{

    public function index()
    {
        $rank = Member::select('post','designation_bn')->distinct()->get();
        $member = Member::leftJoin('results', 'members.bpid', '=', 'results.bpid')
    ->where(function($query) {
        $query->whereNull('results.bpid')
              ->orWhere('results.status', 'failed');
    })
    ->select('members.*','results.exam_id as exam_id')
    ->get();
       

        $exam = Exam::all();
        return view('create-schedule', compact('rank', 'member', 'exam'));
    }

    public function store(Request $req)
    {
        $data = array('name' => $req->configuration, 'total_questions' => $req->numques, 'pass_mark' => $req->pmark, 'exam_id' => $req->exam_id, 'date' => $req->date, 'start_time' => $req->stime, 'end_time' => $req->etime, 'status' => 'deactive');
        $config = Exam_configuration::where('name', $req->configuration)->where('exam_id', $req->exam_id)->where('date', $req->date)->where('start_time',$req->stime)->where('end_time',$req->etime)->get();
        
        if ($req->bpid != null){
            if (count($config) == 0) {
                Exam_configuration::create($data);
                $econfig = Exam_configuration::where('name', $req->configuration)->where('exam_id', $req->exam_id)->where('date', $req->date)->where('start_time',$req->stime)->where('end_time',$req->etime)->first();
                
                // if ($req->bpid != null) {
                    foreach ($req->bpid as $b) {
                        $schedule = array('bpid' => $b, 'exam_config_id' => $econfig->id, 'password' => random_int(100000, 999999));
                        $result = array('bpid'=>$b ,'exam_id'=>$req->exam_id,'total_marks'=>$req->numques,'obtained_marks'=>0,'status'=>'failed','exam_config_id'=>$econfig->id);

                        Exam_Schedule::create($schedule);
                        Result::create($result);
                    }
                // }
                return redirect()->back()->with('success', 'Schedule created successfully');
            } else {
                return redirect()->back()->with('fail', 'configuration name/exam/date already exist!');
            }
        }else{
            return redirect()->back()->with('fail', 'Police must be selected!');
        }
        

    }

}
