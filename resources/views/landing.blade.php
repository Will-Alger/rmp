<x-guest-layout>
    <!-- Session Status (Optional) -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="flex justify-center">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <h2 class="text-2xl mb-4">Welcome</h2>
            <div class="flex items-center justify-between mt-4">
                <a href="{{ route('login') }}"
                   class="underline text-sm hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                   Login
                </a>
                <a href="{{ route('register') }}"
                   class="underline text-sm hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                   Register
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
