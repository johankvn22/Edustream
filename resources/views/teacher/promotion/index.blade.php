@extends('layouts.teacher')

@section('teacher-content')
<div x-data="promotionData()">
    <h2 class="text-2xl font-bold mb-6">Kenaikan Kelas Otomatis</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow border border-indigo-100">
            <label class="block text-sm font-medium mb-2">Kelas Asal</label>
            <select x-model="sourceClass" class="w-full border rounded p-2">
                @foreach($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="flex items-center justify-center">
            <i class="fas fa-arrow-right text-2xl text-indigo-300"></i>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow border border-green-100">
            <label class="block text-sm font-medium mb-2">Kelas Tujuan</label>
            <div x-text="targetClass" class="w-full border rounded p-2 bg-green-50 font-bold text-green-800"></div>
        </div>
    </div>
    
    <form action="{{ route('teacher.promotion.process') }}" method="POST">
        @csrf
        <input type="hidden" name="source_class_id" x-model="sourceClass">
        <input type="hidden" name="target_class_id" x-model="targetClassId">
        
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="p-4 bg-yellow-50 border-b border-yellow-100 flex justify-between items-center">
                <h3 class="font-bold text-yellow-800">Konfirmasi Siswa</h3>
                <span class="text-xs text-yellow-700">Hapus centang jika siswa tinggal kelas</span>
            </div>
            
            <table class="min-w-full divide-y divide-gray-200">
                <tbody class="divide-y divide-gray-200 bg-white">
                    <template x-for="student in students" :key="student.id">
                        <tr :class="!selectedStudents.includes(student.id) ? 'bg-red-50' : ''">
                            <td class="px-6 py-4">
                                <input type="checkbox" :value="student.id" name="student_ids[]" 
                                       x-model="selectedStudents" class="h-5 w-5 text-indigo-600">
                            </td>
                            <td class="px-6 py-4 font-medium" x-text="student.name"></td>
                            <td class="px-6 py-4 text-sm">
                                <span x-show="selectedStudents.includes(student.id)" 
                                      class="text-green-600 font-bold" x-text="'Naik ke ' + targetClass"></span>
                                <span x-show="!selectedStudents.includes(student.id)" 
                                      class="text-red-600 font-bold">Tinggal</span>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
            
            <div class="p-4 bg-gray-50 border-t flex justify-end">
                <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded shadow hover:bg-green-700 font-bold"
                        onclick="return confirm('Naikkan siswa terpilih?')">
                    Proses Kenaikan
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function promotionData() {
        return {
            sourceClass: '{{ $classes->first()->id ?? "" }}',
            students: @json($classes->first()->students ?? []),
            selectedStudents: @json($classes->first()->students->pluck('id') ?? []),
            
            get targetClass() {
                // Simple grade level promotion logic
                const classList = @json($classes);
                const current = classList.find(c => c.id == this.sourceClass);
                if (!current) return 'N/A';
                
                const name = current.name;
                if (name.includes('10')) return name.replace('10', '11');
                if (name.includes('11')) return name.replace('11', '12');
                return 'Lulus';
            },
            
            get targetClassId() {
                const classList = @json($classes);
                const targetName = this.targetClass;
                const target = classList.find(c => c.name === targetName);
                return target ? target.id : null;
            }
        }
    }
</script>
@endsection
