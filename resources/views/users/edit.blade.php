@extends('layouts.app')
@section('title', isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna')
@section('content')
<div class="flex items-center mb-6">
    <a href="{{ route('users.index') }}" class="text-gray-500 hover:text-gray-700 mr-3">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
    </a>
    <h3 class="text-3xl font-bold text-gray-800">{{ isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna' }}</h3>
</div>
<div class="bg-white rounded-lg shadow-sm border border-gray-100 max-w-xl">
    <form action="{{ isset($user) ? route('users.update', $user) : route('users.store') }}" method="POST" class="p-6">
        @csrf
        @if(isset($user)) @method('PUT') @endif
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Lengkap *</label>
                <input type="text" name="name" value="{{ old('name', isset($user) ? $user->name : '') }}" required class="mt-1 block w-full rounded-md border-gray-300 border p-2 shadow-sm focus:border-indigo-500">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Email *</label>
                <input type="email" name="email" value="{{ old('email', isset($user) ? $user->email : '') }}" required class="mt-1 block w-full rounded-md border-gray-300 border p-2 shadow-sm focus:border-indigo-500">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Password {{ isset($user) ? '(Kosongkan jika tidak diubah)' : '*' }}</label>
                <input type="password" name="password" {{ isset($user) ? '' : 'required' }} class="mt-1 block w-full rounded-md border-gray-300 border p-2 shadow-sm focus:border-indigo-500">
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Role *</label>
                <select name="role_id" required class="mt-1 block w-full rounded-md border-gray-300 border p-2 shadow-sm focus:border-indigo-500">
                    <option value="">-- Pilih Role --</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id', isset($user) ? $user->role_id : '') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                </select>
                @error('role_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="flex items-center">
                <input type="checkbox" name="active" id="active" value="1" {{ old('active', isset($user) ? $user->active : true) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                <label for="active" class="ml-2 block text-sm text-gray-900">Akun Aktif</label>
            </div>
        </div>
        <div class="mt-6 flex items-center space-x-3">
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700">Simpan</button>
            <a href="{{ route('users.index') }}" class="text-gray-600 hover:text-gray-800">Batal</a>
        </div>
    </form>
</div>
@endsection