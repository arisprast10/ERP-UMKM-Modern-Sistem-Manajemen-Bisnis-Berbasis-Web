@extends('layouts.auth')
@section('title', 'Login')
@section('content')
    @if(session('error'))
        <div class="mb-4 text-sm font-medium text-red-600 bg-red-100 p-3 rounded">
            {{ session('error') }}
        </div>
    @endif
    <form method="POST" action="/login">
        @csrf
        <div>
            <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
            <input id="email" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 py-2 px-3 border" type="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-gray-700">Password</label>
            <input id="password" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 py-2 px-3 border" type="password" name="password" required>
        </div>

        <div class="block mt-4">
            <label for="remember" class="inline-flex items-center">
                <input id="remember" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                <span class="ml-2 text-sm text-gray-600">Remember me</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            <button class="w-full inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                Log in
            </button>
        </div>
    </form>
@endsection