<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Display a listing of courses
     */
    public function index()
    {
        $courses = Course::with('classes', 'teacher')->get();
        return view('teacher.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new course
     */
    public function create()
    {
        return view('teacher.courses.create');
    }

    /**
     * Store a newly created course
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
        ]);

        $course = Course::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'category' => $validated['category'],
            'teacher_id' => auth()->id(),
            'thumbnail' => '📘',
            'color_theme' => 'bg-gray-600',
        ]);

        return redirect()->route('teacher.courses.edit', $course->id)
            ->with('success', 'Kursus berhasil dibuat!');
    }

    /**
     * Show the form for editing the specified course
     */
    public function edit($id)
    {
        $course = Course::with('lessons')->findOrFail($id);
        return view('teacher.courses.edit', compact('course'));
    }

    /**
     * Update the specified course
     */
    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'string|max:255',
        ]);

        $course->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'category' => $validated['category'] ?? $course->category,
        ]);

        return back()->with('success', 'Perubahan tersimpan!');
    }

    /**
     * Remove the specified course
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('teacher.courses.index')
            ->with('success', 'Kursus dihapus.');
    }

    /**
     * Assign/unassign classes to course
     */
    public function assignClasses(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        
        $classIds = $request->input('class_ids', []);
        $course->classes()->sync($classIds);

        return back()->with('success', 'Tugas tersimpan!');
    }
}
