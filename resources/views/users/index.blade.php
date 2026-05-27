@extends('layouts.app')
@section('title', 'Manajemen Pengguna')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h3 class="text-3xl font-bold text-gray-800">Manajemen Pengguna</h3>
    <a href="{{ route('users.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-medium">+ Tambah Pengguna</a>
</div>
<div class="bg-white rounded-lg shadow-sm border border-gray-100">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3">#</th>
                    <th class="px-6 py-3">Nama</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Role</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $i => $item)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-6 py-4 text-gray-500">{{ $users->firstItem() + $i }}</td>
                    <td class="px-6 py-4 font-medium text-gray-900 flex items-center space-x-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($item->name) }}&background=4f46e5&color=fff&size=32" class="w-8 h-8 rounded-full" alt="">
                        <span>{{ $item->name }}</span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $item->email }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                            {{ $item->role->slug === 'admin' ? 'bg-purple-100 text-purple-700' : ($item->role->slug === 'kasir' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700') }}">
                            {{ $item->role->name }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($item->active)
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">Aktif</span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right space-x-3">
                        <a href="{{ route('users.edit', $item) }}" class="text-blue-600 hover:underline font-medium">Edit</a>
                        @if($item->id !== auth()->id())
                        <form action="{{ route('users.destroy', $item) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus pengguna ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline font-medium">Hapus</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada data pengguna.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t">{{ $users->links() }}</div>
</div>
@endsection