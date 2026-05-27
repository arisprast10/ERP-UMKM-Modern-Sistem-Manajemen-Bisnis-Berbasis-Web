<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-4 rounded-md p-4 {{ $type == 'success' ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800' }}">
    <div class="flex">
        <div class="ml-3">
            <p class="text-sm font-medium">{{ $message }}</p>
        </div>
        <div class="ml-auto pl-3">
            <div class="-mx-1.5 -my-1.5">
                <button @click="show = false" type="button" class="inline-flex rounded-md p-1.5 focus:outline-none focus:ring-2 focus:ring-offset-2 {{ $type == 'success' ? 'text-green-500 hover:bg-green-100 focus:ring-offset-green-50 focus:ring-green-600' : 'text-red-500 hover:bg-red-100 focus:ring-offset-red-50 focus:ring-red-600' }}">
                    <span class="sr-only">Dismiss</span>
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>