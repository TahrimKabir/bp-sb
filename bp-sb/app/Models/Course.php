<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    public function Cstatus()
{
    return $this->hasMany(MembersCourseStatus::class,'course_id','id_courses');
}
}
