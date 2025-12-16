<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Display a listing of students
     */
    public function index()
    {
        $students = User::where('role', 'student')
            ->with('schoolClass')
            ->get();
        
        return view('teacher.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new student
     */
    public function create()
    {
        $classes = SchoolClass::all();
        return view('teacher.students.create', compact('classes'));
    }

    /**
     * Store a newly created student
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'class_id' => 'required|exists:classes,id',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make('siswa'), // Default password
            'role' => 'student',
            'class_id' => $validated['class_id'],
        ]);

        return redirect()->route('teacher.students.index')
            ->with('success', 'Siswa berhasil ditambahkan!');
    }

    /**
     * Remove a student
     */
    public function destroy($id)
    {
        $student = User::where('role', 'student')->findOrFail($id);
        $student->delete();

        return back()->with('success', 'Siswa dihapus.');
    }
}
