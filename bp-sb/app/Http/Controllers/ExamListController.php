<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;
class ExamListController extends Controller
{
    public function index(){
        $exam = Exam::all();
        return view('exam-list',compact('exam'));
    }
}
