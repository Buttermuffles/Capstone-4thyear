@props(['title', 'count', 'icon']) <!-- Accept the icon prop -->

<div class="bg-white px-4 py-2 rounded-lg shadow">
    <div class="flex justify-between items-center">
        <h3 class="text-lg font-normal">{{ $title }}</h3>
        <div class="">
            <i class="{{ $icon }}"></i> <!-- Use the icon prop -->
        </div>
    </div>
    <p class="text-3xl font-medium mt-5">{{ $count }}</p>
</div>
