@extends('layouts.teacher')

@section('teacher-content')
<h2 class="text-2xl font-bold mb-6">Dashboard Guru</h2>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-5 rounded-lg shadow border-l-4 border-indigo-500">
        <div class="text-gray-500 text-sm">Total Murid</div>
        <div class="text-3xl font-bold">{{ $totalStudents }}</div>
    </div>
    
    <div class="bg-white p-5 rounded-lg shadow border-l-4 border-green-500">
        <div class="text-gray-500 text-sm">Kursus Aktif</div>
        <div class="text-3xl font-bold">{{ $activeCourses }}</div>
    </div>
</div>


    
@endsection
