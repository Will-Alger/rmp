<x-landing-layout>
    <style>
        body {
            background-color: rgba(12, 12, 13, 1); /* Dark charcoal color */
        }

    </style>
    <div class="absolute inset-0 flex items-center justify-center">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <h2 class="text-2xl mb-4">Welcome</h2>
            <div class="flex items-center justify-end mt-4">
                <a href="{{ route('login') }}" class="underline text-sm hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Login</a>
                <a href="{{ route('register') }}" class="ml-4 underline text-sm hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Register</a>
            </div>
        </div>
    </div>

    <div class="landing-chart-container">
        <canvas id="myChart" class="w-full h-screen m-0 p-0" style="background-color: rgba(12, 12, 13, 1);"></canvas>
    </div>
@vite('resources/js/LandingPage.js')
</x-landing-layout>
