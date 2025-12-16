@extends('layouts.app')

@section('title', 'EduStream Class')

@section('content')
<div class="relative bg-white overflow-hidden min-h-screen flex flex-col">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pt-6 flex justify-between items-center">
        <span class="text-2xl font-bold text-indigo-600 tracking-tighter">
            EduStream<span class="text-gray-900">Class</span>
        </span>
        <a href="{{ route('login') }}" class="px-6 py-2 rounded-full bg-indigo-600 text-white font-medium hover:bg-indigo-700 transition">
            Masuk
        </a>
    </div>
    
    <main class="mt-16 mx-auto max-w-7xl px-4 sm:mt-24 text-center">
        <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
            <span class="block">Platform Belajar Modern</span>
            <span class="block text-indigo-600">Manajemen Kelas Cerdas</span>
        </h1>
        <p class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
            Sistem kenaikan kelas otomatis, penugasan terstruktur, dan akses aman berbasis peran.
        </p>
        
        <div class="mt-10 bg-yellow-50 border border-yellow-200 p-6 rounded-xl inline-block text-left shadow-sm">
            <p class="font-bold text-yellow-800 mb-3 text-center uppercase tracking-wide text-xs">Akun Demo</p>
            <div class="grid grid-cols-2 gap-8">
                <div class="p-3 rounded border border-yellow-100">
                    <p class="text-xs text-gray-500 uppercase font-bold mb-1">👨‍🏫 Guru</p>
                    <p class="font-mono text-sm">guru@sekolah.id</p>
                    <p class="font-mono text-xs text-gray-400">Password: guru</p>
                </div>
                <div class="p-3 rounded border border-yellow-100">
                    <p class="text-xs text-gray-500 uppercase font-bold mb-1">👤 Siswa</p>
                    <p class="font-mono text-sm">andi@sekolah.id</p>
                    <p class="font-mono text-xs text-gray-400">Password: siswa</p>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
