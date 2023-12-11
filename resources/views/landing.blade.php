<x-guest-layout>
    <!-- Session Status (Optional) -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="flex flex-col justify-between h-full">
        <h2 class="text-2xl mb-4 text-white">Welcome</h2>
        <div class="flex items-center justify-end mt-4">
            <a href="{{ route('login') }}"
            class="underline text-sm text-white hover:text-gray-300  rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Login
            </a>
            <a href="{{ route('register') }}"
            class="underline text-sm text-white hover:text-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ml-4">
            Register
            </a>
        </div>
    </div>
</x-guest-layout>
