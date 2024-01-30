<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembersCourseStatus extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "members_course_status";
    protected $fillable = ['id_members_course_status','member_id','bpid','course_id','pre_evalution',
    'lesson_1','lesson_2','lesson_3','lesson_4','lesson_5','lesson_6','lesson_7','lesson_8',
'exam','exam_mark','post_evalution','course_status','started_at','exam_date','complete_date',
'send_data_pims','data_send_at','certificate_download','certificate_download_at'];
public function courses()
{
    return $this->belongsTo(MembersCourseStatus::class,'id_courses','course_id');
}
public function member()
{
    return $this->belongsTo(Member::class,'member_id','id_members');
}
}
