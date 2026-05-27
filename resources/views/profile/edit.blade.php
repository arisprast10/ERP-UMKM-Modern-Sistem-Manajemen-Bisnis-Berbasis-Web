@extends('layouts.app')
@section('title', 'Profil Saya')

@section('content')
<h3 class="text-3xl font-bold text-gray-800 mb-6">Profil Saya</h3>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Update Info --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b">
            <h4 class="text-lg font-semibold text-gray-700">Informasi Akun</h4>
        </div>
        <form action="/profile" method="POST" class="p-6">
            @csrf
            @method('PUT')
            @if(session('success'))
                <div class="mb-4 p-3 rounded bg-green-50 text-green-700 text-sm font-medium">{{ session('success') }}</div>
            @endif
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 border p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 border p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Role</label>
                    <input type="text" value="{{ $user->role->name ?? '-' }}" disabled
                        class="mt-1 block w-full rounded-md border-gray-200 border p-2 bg-gray-50 text-gray-500">
                </div>
            </div>
            <div class="mt-6">
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    {{-- Update Password --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b">
            <h4 class="text-lg font-semibold text-gray-700">Ubah Password</h4>
        </div>
        <form action="/profile/password" method="POST" class="p-6">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Password Saat Ini</label>
                    <input type="password" name="current_password" required
                        class="mt-1 block w-full rounded-md border-gray-300 border p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Password Baru</label>
                    <input type="password" name="password" required
                        class="mt-1 block w-full rounded-md border-gray-300 border p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" required
                        class="mt-1 block w-full rounded-md border-gray-300 border p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>
            <div class="mt-6">
                <button type="submit" class="px-6 py-2 bg-red-600 text-white font-medium rounded-md hover:bg-red-700 shadow-sm">
                    Ubah Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
