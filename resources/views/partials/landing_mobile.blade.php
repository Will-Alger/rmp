<div class="min-h-screen flex flex-col justify-center items-center">
    <div class="landing-chart-container absolute top-0 left-0 w-full h-screen bg-background-primary">
        <canvas id="myChart" class="w-full h-screen m-0 p-0"></canvas>
    </div>
    <div class="w-full sm:max-w-md mt-2 px-6 py-4 bg-background-secondary shadow-md overflow-hidden sm:rounded-lg relative z-10">
        {{ $slot }}
    </div>
</div>
