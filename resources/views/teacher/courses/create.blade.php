@extends('layouts.teacher')

@section('teacher-content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('teacher.courses.index') }}" class="text-indigo-600 hover:underline">← Kembali</a>
    </div>
    
    <div class="bg-white p-8 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-6">Buat Kursus Baru</h2>
        
        <form action="{{ route('teacher.courses.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Kursus</label>
                <input type="text" name="title" value="{{ old('title') }}" required 
                       class="w-full border rounded p-2 @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="category" required class="w-full border rounded p-2">
                    <option value="Kelas 10 RPL">Kelas 10 RPL</option>
                    <option value="Kelas 11 RPL">Kelas 11 RPL</option>
                    <option value="Kelas 12 RPL">Kelas 12 RPL</option>
                </select>
            </div>
            
            <div class="text-right">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded shadow hover:bg-indigo-700">
                    Simpan & Lanjutkan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
