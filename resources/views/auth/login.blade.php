@extends('layouts.app')

@section('title', 'Login Admin')

@section('content')
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md">
            <h2 class="text-3xl font-bold mb-6 text-center text-blue-600">Login Admin</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="username" class="block text-gray-700 font-medium mb-2">Username</label>
                    <input type="text" id="username" name="username" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 @error('username') border-red-500 @enderror" value="{{ old('username') }}" required>
                    @error('username')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                    <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 @error('password') border-red-500 @enderror" required>
                    @error('password')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                @if($errors->has('credentials'))
                    <div class="mb-4 text-red-600 text-sm">
                        {{ $errors->first('credentials') }}
                    </div>
                @endif

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition">
                    Login
                </button>
            </form>

            <p class="text-center text-gray-600 text-sm mt-4">
                <strong>Default Credentials:</strong><br>
                Username: <code class="bg-gray-100 px-2 py-1">admin</code><br>
                Password: <code class="bg-gray-100 px-2 py-1">admin123</code>
            </p>
        </div>
    </div>
@endsection
