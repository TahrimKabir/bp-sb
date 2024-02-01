<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mcq_question extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['question_id','question','option1','option2','option3','option4','option5','option6','correct_option','time_in_seconds','show_question','type','exam_type'];
}
