<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam_Schedule;
class ScheduleListController extends Controller
{
    public function index(){
        $schedule=Exam_Schedule::all();
        return view('schedule-list',compact('schedule'));
    }
}
