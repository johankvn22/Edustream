@extends('layouts.teacher')

@section('teacher-content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('teacher.courses.index') }}" class="text-indigo-600 hover:underline">← Kembali ke Daftar</a>
        <h2 class="text-2xl font-bold">Editor Kursus</h2>
    </div>
    
    <!-- Course Details -->
    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <form action="{{ route('teacher.courses.update', $course->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <label class="block text-sm font-medium text-gray-700 mb-1">Judul Kursus</label>
            <input type="text" name="title" value="{{ old('title', $course->title) }}" 
                   class="w-full border rounded p-2 mb-4 focus:ring-2 focus:ring-indigo-500">
            
            <div class="text-right mt-4">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
    
    <!-- Lessons List -->
    <div class="bg-white shadow rounded-lg overflow-hidden" x-data="{ showModal: false, lessonType: 'video' }">
        <div class="px-6 py-4 bg-gray-50 border-b flex justify-between items-center">
            <h3 class="font-bold text-gray-700">Kurikulum / Materi</h3>
            <button @click="showModal = true" class="bg-indigo-600 text-white px-3 py-2 rounded text-sm shadow hover:bg-indigo-700">
                + Tambah Materi
            </button>
        </div>
        
        <ul class="divide-y divide-gray-200">
            @forelse($course->lessons as $index => $lesson)
                <li class="px-6 py-4 flex items-center justify-between hover:bg-gray-50">
                    <div class="flex items-center gap-4">
                        <div class="text-gray-400 text-xs font-bold w-4">{{ $index + 1 }}.</div>
                        <div class="h-10 w-10 rounded flex items-center justify-center text-lg {{ $lesson->type === 'quiz' ? 'bg-yellow-100 text-yellow-600' : 'bg-blue-100 text-blue-600' }}">
                            <i class="fas {{ $lesson->type === 'quiz' ? 'fa-question' : 'fa-play' }}"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">{{ $lesson->title }}</div>
                            <div class="text-xs text-gray-500 uppercase">{{ $lesson->type }}</div>
                        </div>
                    </div>
                    <div>
                        <form action="{{ route('teacher.lessons.destroy', $lesson->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus materi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-600">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </li>
            @empty
                <li class="px-6 py-8 text-center text-gray-500 italic">Belum ada materi.</li>
            @endforelse
        </ul>
        
        <!-- Add Lesson Modal -->
        <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center" style="display: none;">
            <div class="absolute inset-0 bg-black/50" @click="showModal = false"></div>
            <div class="bg-white rounded-lg shadow-xl z-10 w-full max-w-md mx-4">
                <form action="{{ route('teacher.lessons.store', $course->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="p-6 space-y-4">
                        <h3 class="font-bold text-lg">Materi Baru</h3>
                        
                        <div class="flex gap-2 bg-gray-100 p-1 rounded">
                            <button type="button" @click="lessonType = 'video'" 
                                    :class="lessonType === 'video' ? 'bg-white shadow' : ''" 
                                    class="flex-1 py-1 rounded text-sm">Video</button>
                            <button type="button" @click="lessonType = 'pdf'" 
                                    :class="lessonType === 'pdf' ? 'bg-white shadow' : ''" 
                                    class="flex-1 py-1 rounded text-sm">PDF</button>
                            <button type="button" @click="lessonType = 'quiz'" 
                                    :class="lessonType === 'quiz' ? 'bg-white shadow' : ''" 
                                    class="flex-1 py-1 rounded text-sm">Kuis</button>
                        </div>
                        
                        <input type="hidden" name="type" x-model="lessonType">
                        <input type="text" name="title" required class="w-full border rounded p-2" placeholder="Judul Materi">
                        
                        <!-- YouTube URL for videos -->
                        <div x-show="lessonType === 'video'">
                            <label class="block text-sm font-medium text-gray-700 mb-1">YouTube URL</label>
                            <input type="url" name="content_url" class="w-full border rounded p-2" 
                                   placeholder="https://www.youtube.com/watch?v=...">
                            <p class="text-xs text-gray-500 mt-1">Paste link video YouTube</p>
                        </div>
                        
                        <!-- PDF Upload -->
                        <div x-show="lessonType === 'pdf'">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Upload PDF</label>
                            <input type="file" name="pdf_file" accept=".pdf" class="w-full border rounded p-2">
                            <p class="text-xs text-gray-500 mt-1">Maksimal 10MB</p>
                        </div>
                        
                        <!-- Duration -->
                        <div x-show="lessonType !== 'quiz'">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Durasi (detik)</label>
                            <input type="number" name="duration_seconds" class="w-full border rounded p-2" 
                                   placeholder="600" value="600">
                        </div>
                    </div>
                    
                    <div class="px-6 py-4 bg-gray-50 text-right space-x-2">
                        <button type="button" @click="showModal = false" class="px-4 py-2 border rounded text-gray-700 hover:bg-gray-100">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
