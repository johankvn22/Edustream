@extends('layouts.app')

@section('title', 'Login - EduStream')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4">
    <div class="max-w-md w-full bg-white p-8 rounded-xl shadow-lg">
        <h2 class="text-3xl font-bold text-center mb-8">Masuk Akun</h2>
        
        @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required 
                       class="mt-1 block w-full border rounded-md py-2 px-3 @error('email') border-red-500 @enderror" 
                       placeholder="nama@sekolah.id">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" required 
                       class="mt-1 block w-full border rounded-md py-2 px-3" 
                       placeholder="••••••••">
            </div>
            
            <button type="submit" class="w-full py-3 px-4 border border-transparent rounded-md text-white bg-indigo-600 hover:bg-indigo-700 font-medium">
                Masuk
            </button>
        </form>
        
        <div class="mt-6 text-center">
            <a href="{{ route('landing') }}" class="text-sm text-gray-500 hover:text-gray-900">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection
