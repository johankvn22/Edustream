@extends('layouts.app')

@section('title', 'Dashboard Siswa - EduStream')
@section('body-class', 'bg-slate-900 text-white')

@section('content')
<header class="bg-slate-900/95 backdrop-blur-md sticky top-0 z-50 border-b border-slate-800 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-indigo-500">EduStream</h1>
        <div class="flex items-center gap-4">
            <div class="text-right hidden md:block">
                <div class="text-sm font-bold">{{ auth()->user()->name }}</div>
                <div class="text-xs text-slate-400">{{ auth()->user()->schoolClass->name ?? '-' }}</div>
            </div>
            <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center font-bold">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-sm px-3 py-2 rounded border border-slate-700 hover:bg-slate-800 hover:border-red-500 text-slate-300 hover:text-red-400 transition">
                    <i class="fas fa-sign-out-alt mr-1"></i> Keluar
                </button>
            </form>
        </div>
    </div>
</header>

<div class="max-w-7xl mx-auto px-4 py-8">
    @yield('student-content')
</div>
@endsection
