<x-landing-layout>
    <style>
        body {
            background-color: rgba(12, 12, 13, 1); /* Dark charcoal color */
        }


    </style>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.3.2"></script>
<script src="https://cdn.jsdelivr.net/npm/luxon@1.27.0"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@1.0.0"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-streaming@2.0.0"></script>

<canvas id="myChart" class="w-full h-screen m-0 p-0" style="background-color: rgba(12, 12, 13, 1);"></canvas>

<div class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl mb-4">Welcome</h2>
    <!-- Insert your content here -->

    <div class="flex items-center justify-end mt-4">
        <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-900">Login</a>
        <a href="{{ route('register') }}" class="ml-4 text-indigo-600 hover:text-indigo-900">Register</a>
    </div>
</div>

<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var initialData = [];
    var secondData = [];
    for (var i = 0; i < 18; i++) {
        initialData.push({
            x: Date.now() - (18 - i) * 10000,
            y: Math.random() * (5 - 1) + 1
        });

        secondData.push({
            x: Date.now() - (18 - i) * 10000,
            y: Math.random() * (5 - 1) + 1
        });
    }
    const backgroundPlugin = {
        id: 'customCanvasBackgroundColor',
        beforeDraw: (chart) => {
            const ctx = chart.ctx;
            const {top, left, width, height} = chart.chartArea;
            ctx.save();
            ctx.fillStyle = 'rgba(12, 12, 13, 1)';
            ctx.fillRect(left, top, width, height);
            ctx.restore();
        }
    };
    const glowPlugin = {
        id: 'glowEffect',
        beforeDatasetDraw: (chart, args) => {
            const ctx = chart.ctx;
            ctx.save();
            ctx.shadowBlur = 20;
            ctx.shadowColor = 'rgba(0, 192, 239, 0.75)';
            ctx.shadowOffsetX = 0;
            ctx.shadowOffsetY = 0;
        },
        afterDatasetDraw: (chart, args) => {
            chart.ctx.restore();
        }
    };
    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            datasets: [{
                data: initialData,
                borderColor: '#00c0ef',
                fill: true,
                backgroundColor: (context) => {
                const chart = context.chart;
                const {ctx, chartArea} = chart;
                if (!chartArea) {
                    return null;
                }
                const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                gradient.addColorStop(0, 'rgba(0, 192, 239, .125)'); // Less transparent near the line
                gradient.addColorStop(1, 'rgba(0, 192, 239, 0.0)'); // Fully transparent further down

                return gradient;
            },
                cubicInterpolationMode: 'monotone',
            },
            {
            data: secondData,
            borderColor: '#00ff00',
            fill: true,
            backgroundColor: (context) => {
                const chart = context.chart;
                const {ctx, chartArea} = chart;
                if (!chartArea) {
                    return null;
                }
                const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                gradient.addColorStop(0, 'rgba(0, 255, 0, .125)'); // Less transparent near the line
                gradient.addColorStop(1, 'rgba(0, 255, 0, 0.0)'); // Fully transparent further down further down

                return gradient;
            },
            cubicInterpolationMode: 'monotone',
        }
        ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    ticks: {
                        display: false,
                    },
                    type: 'realtime',
                    realtime: {
                        duration: 90000,
                        refresh: 2000,
                        delay: 2000,
                        onRefresh: function(chart) {
                            chart.data.datasets.forEach(function(dataset) {
                                var lastDataPoint = dataset.data[dataset.data.length - 1];
                                var newX = lastDataPoint ? lastDataPoint.x + 10000 : Date.now();
                                dataset.data.push({
                                    x: newX,
                                    y: Math.random() * (5 - 1) + 1
                                });
                            });
                        }
                    },
                },
                y: {
                    type: 'linear',
                    ticks: {
                        display: false,
                    },
                }
            }
        },
        plugins: [backgroundPlugin, glowPlugin]
    });
</script>

</x-landing-layout>
