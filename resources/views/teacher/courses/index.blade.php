@extends('layouts.teacher')

@section('teacher-content')
<div class="flex justify-between mb-6">
    <h2 class="text-2xl font-bold">Manajemen Kursus</h2>
    <a href="{{ route('teacher.courses.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded shadow hover:bg-indigo-700">
        + Kursus Baru
    </a>
</div>

<div class="bg-white shadow rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ditugaskan Ke</th>
                <th class="px-6 py-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($courses as $course)
                <tr>
                    <td class="px-6 py-4 font-medium flex items-center gap-2">
                        <span class="text-xl">{{ $course->thumbnail }}</span>
                        {{ $course->title }}
                    </td>
                    <td class="px-6 py-4 text-gray-500 text-sm">{{ $course->category }}</td>
                    <td class="px-6 py-4">
                        @if($course->classes->count() > 0)
                            @foreach($course->classes as $class)
                                <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded mr-1">{{ $class->name }}</span>
                            @endforeach
                        @else
                            <span class="text-gray-400 text-xs italic">Belum ditugaskan</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right text-sm">
                        <a href="{{ route('teacher.courses.edit', $course->id) }}" class="text-gray-500 hover:text-indigo-600 mr-2" title="Edit Materi">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('teacher.courses.destroy', $course->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus kursus ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700" title="Hapus Kursus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada kursus</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
