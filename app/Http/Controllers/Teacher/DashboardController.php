<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;

class DashboardController extends Controller
{
    /**
     * Display teacher dashboard with statistics
     */
    public function index()
    {
        $totalStudents = User::where('role', 'student')->count();
        $activeCourses = Course::count();
        
        return view('teacher.dashboard', compact('totalStudents', 'activeCourses'));
    }
}
