<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Exam_Schedule as ExamSchedule;
use App\Models\Exam_configuration as ExamConfiguration;

class Result extends Model
{
    use HasFactory;
    protected $casts = [
        'result_details' => 'json',
    ];
    protected $fillable=[

        'bpid' ,
        'total_marks' ,
        'obtained_marks' ,
        'status',
        'exam_id',
        'exam_config_id',
        'result_details',
        'exam_schedule_id'
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id', 'exam_id');
    }


    public function examConfiguration()
    {
        return $this->belongsTo(ExamConfiguration::class, 'exam_config_id', 'id');
    }


    public function member()
    {
        return $this->belongsTo(Member::class, 'bpid', 'bpid');
    }
    public function examSchedule()
    {
        return $this->belongsTo(ExamSchedule::class, 'exam_schedule_id', 'id');
    }
}
