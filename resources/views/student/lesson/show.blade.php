@extends('layouts.app')

@section('title', $lesson->title . ' - EduStream')
@section('body-class', 'bg-black text-white')

@section('content')
<div class="h-screen flex flex-col md:flex-row overflow-hidden">
    <!-- Main Player Area -->
    <div class="flex-1 flex flex-col relative">
        <div class="absolute top-4 left-4 z-10">
            <a href="{{ route('student.dashboard') }}" class="bg-black/50 px-3 py-2 rounded-full backdrop-blur text-sm hover:bg-black/70 transition">
                ← Dashboard
            </a>
        </div>
        
        <!-- Content based on type -->
        @if($lesson->type === 'quiz' && $lesson->questions->count() > 0)
            <div class="flex-1 bg-slate-900 flex flex-col items-center justify-center p-8 overflow-y-auto" x-data="quizData()">
                <div class="bg-slate-800 p-8 rounded-xl shadow-2xl max-w-2xl w-full border border-slate-700">
                    <div class="flex justify-between items-center mb-6 pb-4 border-b border-slate-700">
                        <h2 class="text-2xl font-bold">{{ $lesson->title }}</h2>
                        <span class="bg-indigo-900 text-indigo-300 px-3 py-1 rounded text-xs font-bold">Kuis</span>
                    </div>
                    
                    <div x-show="!submitted">
                        <form @submit.prevent="submitQuiz">
                            @foreach($lesson->questions as $index => $question)
                                <div class="mb-6">
                                    <p class="text-lg mb-3 font-medium">{{ $index + 1 }}. {{ $question->question_text }}</p>
                                    <div class="space-y-2">
                                        @foreach($question->options as $option)
                                            <label class="flex items-center gap-3 p-3 rounded border border-slate-700 hover:bg-slate-700/50 cursor-pointer transition">
                                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}" 
                                                       class="w-5 h-5 text-indigo-600 bg-slate-900 border-slate-600">
                                                <span class="text-slate-300">{{ $option->option_text }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                            
                            <button type="submit" class="w-full py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold rounded-lg shadow-lg">
                                Kirim Jawaban
                            </button>
                        </form>
                    </div>
                    
                    <div x-show="submitted" x-cloak class="text-center py-12">
                        <div class="inline-block p-4 rounded-full bg-green-100 mb-4">
                            <i class="fas fa-check text-4xl text-green-600"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">Kuis Selesai!</h3>
                        <p class="text-slate-400 mb-6">Jawaban Anda telah direkam.</p>
                        <div class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-emerald-600 mb-8" x-text="score + '/100'"></div>
                        <a href="{{ route('student.dashboard') }}" class="px-6 py-2 border border-slate-600 rounded-full text-slate-300 hover:bg-slate-800 hover:text-white transition inline-block">
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        @elseif($lesson->type === 'video' && $lesson->content_url)
            <!-- YouTube Video Player -->
            <div class="flex-1 bg-black flex items-center justify-center">
                <iframe 
                    class="w-full h-full"
                    src="{{ $lesson->content_url }}" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen>
                </iframe>
            </div>
        @elseif($lesson->type === 'pdf' && $lesson->content_url)
            <!-- PDF Viewer -->
            <div class="flex-1 bg-gray-800 overflow-auto flex flex-col">
                <div class="flex-1 relative">
                    <embed 
                        src="{{ $lesson->content_url }}#toolbar=1&navpanes=1&scrollbar=1" 
                        type="application/pdf"
                        class="w-full h-full">
                    </embed>
                </div>
                <div class="p-4 bg-slate-900 border-t border-slate-800 flex justify-between items-center">
                    <span class="text-sm text-slate-400">
                        <i class="fas fa-file-pdf mr-2"></i>Dokumen PDF
                    </span>
                    <a href="{{ $lesson->content_url }}" 
                       download 
                       target="_blank"
                       class="px-4 py-2 bg-indigo-600 text-white rounded text-sm hover:bg-indigo-700 transition">
                        <i class="fas fa-download mr-1"></i> Download PDF
                    </a>
                </div>
            </div>
        @else
            <!-- Placeholder for no content -->
            <div class="flex-1 bg-black flex items-center justify-center relative flex-col">
                <i class="fas fa-{{ $lesson->type === 'video' ? 'play-circle' : 'file-pdf' }} text-8xl text-slate-700 opacity-50"></i>
                <p class="mt-6 text-slate-500">
                    @if($lesson->type === 'video')
                        Video belum ditambahkan
                    @elseif($lesson->type === 'pdf')
                        PDF belum diupload
                    @else
                        Konten tidak tersedia
                    @endif
                </p>
            </div>
        @endif
        
        <!-- Bottom Bar -->
        <div class="p-4 bg-slate-900 border-t border-slate-800 flex justify-between items-center">
            <div>
                <h2 class="font-bold">{{ $lesson->title }}</h2>
                <p class="text-xs text-slate-400">{{ $lesson->duration_seconds }} detik</p>
            </div>
        </div>
    </div>
    
    <!-- Lesson Sidebar -->
    <div class="w-full md:w-80 bg-slate-900 border-l border-slate-800 flex flex-col h-full">
        <div class="p-4 border-b border-slate-800 font-bold">{{ $course->title }}</div>
        <div class="flex-1 overflow-y-auto p-2 space-y-1">
            @foreach($course->lessons as $index => $l)
                <a href="{{ route('student.lessons.show', [$course->id, $l->id]) }}" 
                   class="p-3 rounded cursor-pointer flex items-center gap-3 transition {{ $l->id === $lesson->id ? 'bg-indigo-900/50 border border-indigo-500/50 text-white' : 'text-slate-400 hover:bg-slate-800' }}">
                    <div class="text-xs w-6 text-center text-slate-500 font-mono">{{ $index + 1 }}</div>
                    <div class="flex-1">
                        <div class="text-sm font-medium">{{ $l->title }}</div>
                        <div class="text-[10px] opacity-70 uppercase tracking-wider mt-0.5">{{ $l->type }}</div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>

<script>
    function quizData() {
        return {
            submitted: false,
            score: 0,
            
            async submitQuiz(event) {
                const formData = new FormData(event.target);
                
                try {
                    const response = await fetch('{{ route("student.quiz.submit", $lesson->id) }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: formData
                    });
                    
                    const result = await response.json();
                    this.score = result.score;
                    this.submitted = true;
                } catch (error) {
                    console.error('Error submitting quiz:', error);
                    alert('Terjadi kesalahan saat mengirim jawaban');
                }
            }
        }
    }
</script>

<style>
    [x-cloak] { display: none !important; }
</style>
@endsection
