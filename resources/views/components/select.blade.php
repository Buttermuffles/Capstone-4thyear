<!-- resources/views/components/select.blade.php -->

<div class="mb-4">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    <select name="{{ $name }}" id="{{ $name }}" wire:model="{{ $model }}"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        {{ $slot }}
    </select>
</div>
