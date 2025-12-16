<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'category', 'thumbnail', 'color_theme', 'teacher_id'];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function classes()
    {
        return $this->belongsToMany(SchoolClass::class, 'course_class', 'course_id', 'class_id')
                    ->withPivot('assigned_at');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('order_sequence');
    }
}
