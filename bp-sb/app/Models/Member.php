<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    public function cstatus()
{
    return $this->hasmany(MembersCourseStatus::class,'id_members','member_id');
}

}
