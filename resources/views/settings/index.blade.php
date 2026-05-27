@extends('layouts.app')
@section('title', 'Pengaturan Toko')
@section('content')
<h3 class="text-3xl font-bold text-gray-800 mb-6">Pengaturan Toko</h3>
<div class="bg-white rounded-lg shadow-sm border border-gray-100 max-w-2xl">
    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" class="p-6">
        @csrf
        @method('PUT')
        
        @if(session('success'))
            <div class="mb-4 p-3 rounded bg-green-50 text-green-700 text-sm">{{ session('success') }}</div>
        @endif

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Toko / Usaha *</label>
                <input type="text" name="store_name" value="{{ old('store_name', $setting->store_name) }}" required class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 p-2 border">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">No. Telepon / WhatsApp</label>
                <input type="text" name="store_phone" value="{{ old('store_phone', $setting->store_phone) }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 p-2 border">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Alamat Toko</label>
                <textarea name="store_address" rows="3" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 p-2 border">{{ old('store_address', $setting->store_address) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Logo Toko</label>
                @if($setting->store_logo)
                    <div class="mt-2 mb-2">
                        <img src="{{ asset('storage/' . $setting->store_logo) }}" class="h-20 w-auto object-contain bg-gray-50 border rounded p-1">
                    </div>
                @endif
                <input type="file" name="store_logo" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:bg-indigo-50 file:text-indigo-700">
            </div>
        </div>

        <div class="mt-6 pt-4 border-t">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md font-medium hover:bg-indigo-700">Simpan Pengaturan</button>
        </div>
    </form>
</div>
@endsection