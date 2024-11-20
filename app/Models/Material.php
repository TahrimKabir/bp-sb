<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $table = 'materials';
protected $primaryKey='material_id';
    protected $fillable = ['lesson_id', 'material_type', 'material_url', 'material_name', 'created_at'];
}
