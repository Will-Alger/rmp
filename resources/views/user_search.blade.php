<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight hover:text-electric-violet transition duration-500 ease-in-out transform hover:-translate-y-1 hover:scale-110">
            {{ __('RateMyProfessor 2.0') }}
        </h2>
    </x-slot>

    <div class="flex items-center justify-center">
        <div class="mt-20 w-1/3">
            @livewire('search', ['searchType' => 'professor'])
        </div>
    </div>
</x-app-layout>
