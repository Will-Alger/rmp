<x-landing-layout>
    <style>
        body {
            background-color: rgba(12, 12, 13, 1); /* Dark charcoal color */
        }

    </style>
    <div class="absolute inset-0 flex items-center justify-center">
        <div class="bg-white shadow-md rounded-lg p-6 w-full sm:w-96">
            <h2 class="text-2xl mb-4">Welcome</h2>
            <!-- Insert your content here -->

            <div class="flex items-center justify-end mt-4">
                <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-900">Login</a>
                <a href="{{ route('register') }}" class="ml-4 text-indigo-600 hover:text-indigo-900">Register</a>
            </div>
        </div>
    </div>
    <div class="landing-chart-container">
        <canvas id="myChart" class="w-full h-screen m-0 p-0" style="background-color: rgba(12, 12, 13, 1);"></canvas>
    </div>
@vite('resources/js/LandingPage.js')
</x-landing-layout>
