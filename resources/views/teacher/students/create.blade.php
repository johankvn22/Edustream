@extends('layouts.teacher')

@section('teacher-content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('teacher.students.index') }}" class="text-indigo-600 hover:underline">← Kembali</a>
    </div>
    
    <div class="bg-white p-8 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-6">Tambah Siswa Baru</h2>
        
        <form action="{{ route('teacher.students.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}" required 
                       class="w-full border rounded p-2">
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required 
                       class="w-full border rounded p-2">
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                <select name="class_id" required class="w-full border rounded p-2">
                    <option value="">Pilih Kelas</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="text-right">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded shadow hover:bg-indigo-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
