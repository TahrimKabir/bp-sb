<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExamListController extends Controller
{
    public function index(){
        return view('exam-list');
    }
}
