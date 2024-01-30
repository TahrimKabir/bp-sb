<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScheduleListController extends Controller
{
    public function index(){
        return view('schedule-list');
    }
}
