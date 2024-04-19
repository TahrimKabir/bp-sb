<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model implements Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'bpid',
        'name',
        'designation',
        'post',
        'posting_area',
        'mobile',
        'dob',
        'joining_date',
    ];

    protected $guard = 'member';

    public function schedule()
    {
        return $this->hasMany(Exam_Schedule::class, 'bpid', 'bpid');
    }

    public function result()
    {
        return $this->hasMany(Result::class, 'bpid', 'bpid');
    }

    public function getAuthIdentifierName()
    {
        return 'bpid';
    }

    public function getAuthIdentifier()
    {
        return $this->bpid;
    }

    public function getAuthPassword()
    {
        return null;
    }

    public function getRememberToken()
    {
        //
    }

    public function setRememberToken($value)
    {
        //
    }

    public function getRememberTokenName()
    {
        //
    }
}
