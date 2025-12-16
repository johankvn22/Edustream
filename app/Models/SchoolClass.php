<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;
    
    protected $table = 'classes';
    protected $fillable = ['name', 'grade_level'];

    public function students()
    {
        return $this->hasMany(User::class, 'class_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_class', 'class_id', 'course_id')
                    ->withPivot('assigned_at');
    }
}
