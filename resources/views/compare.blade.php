<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight hover:text-red-800">
            {{ __('RateMyProfessor 2.0') }}
        </h2>
    </x-slot>

<div class="flex justify-center items-center w-full">
    <div class="w-2/3">
        @livewire('search-professor')
    </div>
</div>
</x-app-layout>

