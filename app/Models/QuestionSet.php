<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionSet extends Model
{
    use HasFactory;
    protected $table="question_sets";
    protected $primaryKey="question_set_id";
    protected $fillable=[
        'question_set_name',
        'num_of_mcq',
        'num_of_true_false',
        'num_of_typing_test',
        'type'
    ];

    public function questions(){
        return $this->hasMany(ComputerTestQuestion::class,'question_set_id','question_set_id');
    }
}
