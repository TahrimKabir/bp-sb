<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;


// Define the table name if it's different from the default 'courses'
    protected $table = 'courses';

    // Define the primary key column name
    protected $primaryKey = 'id_courses';

    // Specify the columns that can be mass assigned
    protected $fillable = [
        'title',
        'status',
        'target_trainee',
        'course_no',
        'created_at',
        'updated_at',
    ];

    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'courses_id', 'id_courses');
    }
}
