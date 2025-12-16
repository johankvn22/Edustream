@extends('layouts.teacher')

@section('teacher-content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Data Siswa & Akses</h2>
    <a href="{{ route('teacher.students.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded shadow hover:bg-indigo-700 flex items-center gap-2">
        <i class="fas fa-user-plus"></i> Tambah Murid
    </a>
</div>

<div class="bg-white shadow rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kelas</th>
                <th class="px-6 py-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($students as $student)
                <tr>
                    <td class="px-6 py-4 font-medium">{{ $student->name }}</td>
                    <td class="px-6 py-4 text-gray-500 font-mono text-sm bg-gray-50 rounded">{{ $student->email }}</td>
                    <td class="px-6 py-4">
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-bold">
                            {{ $student->schoolClass->name ?? '-' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <form action="{{ route('teacher.students.destroy', $student->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data siswa ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada siswa</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
