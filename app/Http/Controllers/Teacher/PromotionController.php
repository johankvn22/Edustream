<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    /**
     * Display class promotion interface
     */
    public function index()
    {
        $classes = SchoolClass::all();
        return view('teacher.promotion.index', compact('classes'));
    }

    /**
     * Process class promotion for selected students
     */
    public function process(Request $request)
    {
        $validated = $request->validate([
            'source_class_id' => 'required|exists:classes,id',
            'target_class_id' => 'required|exists:classes,id',
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:users,id',
        ]);

        // Update selected students to new class
        User::whereIn('id', $validated['student_ids'])
            ->update(['class_id' => $validated['target_class_id']]);

        return back()->with('success', 'Kenaikan kelas berhasil!');
    }
}
