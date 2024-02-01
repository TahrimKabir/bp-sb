<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam_Schedule extends Model
{
    use HasFactory;
    protected $table = 'exam_schedule';
    public $timestamps = false;
    protected $fillable = ['bpid','exam_config_id','status','password','login_time','submission_time'];
}
