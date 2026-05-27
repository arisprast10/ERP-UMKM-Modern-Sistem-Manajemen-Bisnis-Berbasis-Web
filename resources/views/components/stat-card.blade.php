@props(['title', 'value', 'icon', 'color' => 'indigo'])
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 flex items-center">
        <div class="p-3 rounded-full bg-{{ $color }}-100 text-{{ $color }}-600">
            {!! $icon !!}
        </div>
        <div class="ml-4">
            <p class="text-sm text-gray-500 font-medium">{{ $title }}</p>
            <p class="text-2xl font-bold text-gray-800">{{ $value }}</p>
        </div>
    </div>
</div>