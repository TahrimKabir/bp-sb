<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam_configuration extends Model
{
    use HasFactory;
    protected $table = 'exam_configuration';
    public $timestamps = false;
    protected $fillable=['name','total_questions','pass_mark','exam_id','date','start_time','end_time','result_publish_status','status'	];
}
