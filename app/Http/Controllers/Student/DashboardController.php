<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\StudentProgress;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display student LMS dashboard
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $filter = $request->get('filter', 'semua');

        // Get courses assigned to student's class
        $courses = Course::whereHas('classes', function($query) use ($user) {
            $query->where('classes.id', $user->class_id);
        })
        ->with(['lessons', 'classes'])
        ->get()
        ->map(function($course) use ($user) {
            // Calculate progress percentage
            $totalLessons = $course->lessons->count();
            $completedLessons = StudentProgress::where('user_id', $user->id)
                ->where('is_completed', true)
                ->whereIn('lesson_id', $course->lessons->pluck('id'))
                ->count();
            
            $progress = $totalLessons > 0 ? ($completedLessons / $totalLessons) * 100 : 0;
            
            // Determine status
            $isAssigned = $course->classes->contains('id', $user->class_id);
            if ($progress == 100) {
                $status = 'selesai diikuti';
            } elseif ($progress > 0) {
                $status = 'sedang dikerjakan';
            } elseif ($isAssigned) {
                $status = 'harus dikerjakan';
            } else {
                $status = 'belum diambil';
            }
            
            $course->user_progress = $progress;
            $course->status = $status;
            
            return $course;
        });

        // Apply filter
        if ($filter !== 'semua') {
            $courses = $courses->where('status', $filter);
        }

        return view('student.dashboard', compact('courses', 'filter'));
    }
}
