@extends('layouts.student')

@section('student-content')
<h2 class="text-3xl font-bold mb-2">Dashboard Belajar</h2>

<div class="flex gap-3 mb-8 overflow-x-auto pb-2 mt-4">
    <a href="{{ route('student.dashboard') }}" 
       class="px-3 py-1 rounded-full text-xs font-semibold {{ !request('filter') || request('filter') == 'semua' ? 'bg-white text-gray-900' : 'bg-white/10 text-gray-400 hover:bg-white/20' }}">
        Semua
    </a>
    <a href="{{ route('student.dashboard', ['filter' => 'harus dikerjakan']) }}" 
       class="px-3 py-1 rounded-full text-xs font-semibold {{ request('filter') == 'harus dikerjakan' ? 'bg-white text-gray-900' : 'bg-white/10 text-gray-400 hover:bg-white/20' }}">
        Harus Dikerjakan
    </a>
    <a href="{{ route('student.dashboard', ['filter' => 'sedang dikerjakan']) }}" 
       class="px-3 py-1 rounded-full text-xs font-semibold {{ request('filter') == 'sedang dikerjakan' ? 'bg-white text-gray-900' : 'bg-white/10 text-gray-400 hover:bg-white/20' }}">
        Sedang Dikerjakan
    </a>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 fade-in">
    @forelse($courses as $course)
        <a href="{{ route('student.lessons.show', [$course->id, $course->lessons->first()->id ?? 0]) }}" 
           class="bg-slate-800 rounded-xl overflow-hidden border border-slate-700 hover:border-indigo-500 cursor-pointer relative block">
            <div class="h-40 {{ $course->color_theme }} flex items-center justify-center text-5xl relative">
                {{ $course->thumbnail }}
                <div class="absolute top-3 right-3 px-2 py-1 rounded text-[10px] font-bold uppercase bg-black/60 backdrop-blur-sm border border-white/20 shadow">
                    {{ $course->status }}
                </div>
            </div>
            <div class="p-4">
                <div class="text-xs text-indigo-400 font-bold uppercase mb-1">{{ $course->category }}</div>
                <h3 class="font-bold text-lg mb-3 line-clamp-1">{{ $course->title }}</h3>
                <div class="w-full bg-gray-700 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-green-500 h-full rounded-full" style="width: {{ $course->user_progress }}%"></div>
                </div>
            </div>
        </a>
    @empty
        <div class="col-span-full text-center py-12 text-slate-500 border border-dashed border-slate-700 rounded-xl">
            Tidak ada materi.
        </div>
    @endforelse
</div>
@endsection
