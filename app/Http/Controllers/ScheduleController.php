<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Exam_configuration;
use App\Models\Exam_Schedule;
use App\Models\Member;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{

    public function index()
    {
        $rank = Member::select('post', 'designation_bn')->distinct()->get();
        $member = Member::leftJoin('results', 'members.bpid', '=', 'results.bpid')
            ->where(function ($query) {
                $query->whereNull('results.bpid')
                    ->orWhere('results.status', 'failed');
            })
            ->select('members.*', 'results.exam_id as exam_id')
            ->get();

        $exam = Exam::all();
        return view('create-schedule', compact('rank', 'member', 'exam'));
    }

    public function store(Request $request)
    {
        // Validation rules
        $rules = [
            'configuration' => 'required|string',

            'date' => 'required|date',
            'stime' => 'required|date_format:H:i',
            'etime' => 'required|date_format:H:i|after:stime',
            'bpid' => 'required|array',

            'numques' => 'nullable|numeric',
            'pmark' => 'nullable|numeric',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Data is valid, proceed to store


        $data = [
            'name' => $request->configuration,
            'total_questions' => $request->has('numques') ? $request->numques : null,
            'pass_mark' => $request->has('pmark') ? $request->pmark : null,
            'exam_id' => $request->exam_id,
            'date' => $request->date,
            'start_time' => $request->stime,
            'end_time' => $request->etime,
            'status' => 'deactive',
            'question_set_id'=>$request->has('question_set_id')?$request->question_set_id : null,
        ];

        $configExists = Exam_configuration::where('name', $request->configuration)
            ->where('exam_id', $request->exam_id)
            ->where('date', $request->date)
            ->where('start_time', $request->stime)
            ->where('end_time', $request->etime)
            ->exists();

        if (!$configExists) {
            if (strtotime($request->stime) < strtotime($request->etime)) {
                $examConfig = Exam_configuration::create($data);

                foreach ($request->bpid as $bpid) {
                    $schedule = [
                        'bpid' => $bpid,
                        'exam_config_id' => $examConfig->id,
                        'password' => random_int(100000, 999999)
                    ];

                    Exam_Schedule::create($schedule);
                }

                return redirect()->back()->with('success', 'Schedule created successfully');
            } else {
                return redirect()->back()->with('fail', 'Start time cannot be greater than the end time!');
            }
        } else {
            return redirect()->back()->with('fail', 'Configuration name/exam/date already exists!');
        }
    }

}
