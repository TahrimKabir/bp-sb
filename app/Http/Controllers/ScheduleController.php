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

    public function createSchedule()
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
        return view('Examschedule.create-schedule', compact('rank', 'member', 'exam'));
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


    public function showAddMembersForm($configurationId)
    {
        // Fetch the specific exam configuration by ID
        $examConfiguration = Exam_configuration::findOrFail($configurationId);
        if (now() >= $examConfiguration->start_time) {
            return redirect()->back()->with('fail', 'The exam has already started. You cannot add new members.');
        }

        $alreadyAddedMemberIds = Exam_Schedule::where('exam_config_id', $configurationId)
            ->pluck('bpid')
            ->toArray();

        $member = Member::whereNotIn('bpid', $alreadyAddedMemberIds)->get();

        $rank = Member::select('post', 'designation_bn')->distinct()->get();


        return view('Examschedule.add-members', compact('examConfiguration','rank','member'));
    }


    public function addMembers(Request $request)
    {
        $validated = $request->validate([
            'exam_config_id' => 'required|exists:exam_configuration,id',
            'bpid' => 'required|array|min:1',

        ]);

        $examConfig = Exam_configuration::find($validated['exam_config_id']);

        // Ensure the current time is before the start time of the exam
        if (now() >= $examConfig->start_time) {
            return redirect()->back()->with('fail', 'You cannot add members after the exam start time.');
        }

        // Add new members to the Exam_Schedule table
        foreach ($validated['bpid'] as $bpid) {
            Exam_Schedule::create([
                'bpid' => $bpid,
                'exam_config_id' => $examConfig->id,
                'password' => random_int(100000, 999999), // Generate a random password
            ]);
        }

        return redirect()->route('schedule.show',$examConfig->id)->with('success', 'Members added successfully!');

    }


}
