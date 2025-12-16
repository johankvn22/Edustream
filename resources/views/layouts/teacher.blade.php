@extends('layouts.app')

@section('title', 'Dashboard Guru - EduStream')
@section('body-class', 'bg-gray-50 text-gray-800')

@section('content')
<div class="min-h-screen flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-gray-200 hidden md:flex flex-col fixed h-full z-10">
        <div class="h-16 flex items-center px-6 border-b border-gray-200 font-bold text-xl text-indigo-700">
            EduStream<span class="text-gray-500 font-normal text-sm ml-1">Guru</span>
        </div>
        
        <nav class="flex-1 px-4 py-6 space-y-1">
            <a href="{{ route('teacher.dashboard') }}" class="w-full flex items-center px-2 py-3 text-sm font-medium rounded-md {{ request()->routeIs('teacher.dashboard') ? 'bg-indigo-50 text-indigo-700 border-r-4 border-indigo-600' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="mr-3 text-lg">📊</span> Dashboard
            </a>
            <a href="{{ route('teacher.courses.index') }}" class="w-full flex items-center px-2 py-3 text-sm font-medium rounded-md {{ request()->routeIs('teacher.courses.*') ? 'bg-indigo-50 text-indigo-700 border-r-4 border-indigo-600' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="mr-3 text-lg">📚</span> Manajemen Kursus
            </a>
            <a href="{{ route('teacher.students.index') }}" class="w-full flex items-center px-2 py-3 text-sm font-medium rounded-md {{ request()->routeIs('teacher.students.*') ? 'bg-indigo-50 text-indigo-700 border-r-4 border-indigo-600' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="mr-3 text-lg">👥</span> Data Siswa & Akses
            </a>
            <a href="{{ route('teacher.promotion.index') }}" class="w-full flex items-center px-2 py-3 text-sm font-medium rounded-md {{ request()->routeIs('teacher.promotion.*') ? 'bg-indigo-50 text-indigo-700 border-r-4 border-indigo-600' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="mr-3 text-lg">🎓</span> Kenaikan Kelas
            </a>
        </nav>
        
        <div class="p-4 border-t">
            <div class="flex items-center mb-3">
                <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold mr-3">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div>
                    <div class="text-sm font-bold text-gray-900">{{ auth()->user()->name }}</div>
                    <div class="text-xs text-gray-500">Administrator</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-sm text-red-600 hover:bg-red-50 py-2 rounded border border-red-200">
                    Keluar
                </button>
            </form>
        </div>
    </aside>
    
    <!-- Main Content -->
    <main class="flex-1 md:ml-64 p-8 fade-in">
        @yield('teacher-content')
    </main>
</div>
@endsection
