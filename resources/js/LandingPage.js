import Chart from "chart.js/auto";
import { DateTime } from "luxon";
import "chartjs-adapter-luxon";
import ChartStreaming from "chartjs-plugin-streaming";
Chart.register(ChartStreaming);

document.addEventListener("DOMContentLoaded", () => {
    var ctx = document.getElementById("myChart").getContext("2d");
    var initialData = [];
    var secondData = [];
    for (var i = 0; i < 18; i++) {
        initialData.push({
            x: Date.now() - (18 - i) * 10000,
            y: Math.random() * (5 - 1) + 1,
        });
        secondData.push({
            x: Date.now() - (18 - i) * 10000,
            y: Math.random() * (5 - 1) + 1,
        });
    }
    const backgroundPlugin = {
        id: "customCanvasBackgroundColor",
        beforeDraw: (chart) => {
            const ctx = chart.ctx;
            const { top, left, width, height } = chart.chartArea;
            ctx.save();
            ctx.fillStyle = "rgba(12, 12, 13, 1)";
            ctx.fillRect(left, top, width, height);
            const dotSize = 0.5;
            const spacing = 50;
            ctx.fillStyle = "#FFFFFF";
            for (let x = left; x <= left + width; x += spacing) {
                for (let y = top; y <= top + height; y += spacing) {
                    ctx.beginPath();
                    ctx.arc(x, y, dotSize, 0, Math.PI * 2);
                    ctx.fill();
                }
            }
            ctx.restore();
        },
    };

    const glowPlugin = {
        id: "glowEffect",
        beforeDatasetDraw: (chart, args) => {
            const ctx = chart.ctx;
            ctx.save();
            ctx.shadowBlur = 20;
            ctx.shadowColor = "rgba(0, 192, 239, 0.75)";
            ctx.shadowOffsetX = 0;
            ctx.shadowOffsetY = 0;
        },
        afterDatasetDraw: (chart, args) => {
            chart.ctx.restore();
        },
    };
    var chart = new Chart(ctx, {
        type: "line",
        data: {
            datasets: [
                {
                    data: initialData,
                    borderColor: "#00c0ef",
                    fill: true,
                    pointRadius: 0,
                    backgroundColor: (context) => {
                        const chart = context.chart;
                        const { ctx, chartArea } = chart;
                        if (!chartArea) {
                            return null;
                        }
                        const gradient = ctx.createLinearGradient(
                            0,
                            chartArea.bottom,
                            0,
                            chartArea.top
                        );
                        gradient.addColorStop(0, "rgba(0, 192, 239, .125)"); // Less transparent near the line
                        gradient.addColorStop(1, "rgba(0, 192, 239, 0.0)"); // Fully transparent further down

                        return gradient;
                    },
                    cubicInterpolationMode: "monotone",
                },
                {
                    data: secondData,
                    borderColor: "#00ff00",
                    fill: true,
                    pointRadius: 0,
                    backgroundColor: (context) => {
                        const chart = context.chart;
                        const { ctx, chartArea } = chart;
                        if (!chartArea) {
                            return null;
                        }
                        const gradient = ctx.createLinearGradient(
                            0,
                            chartArea.bottom,
                            0,
                            chartArea.top
                        );
                        gradient.addColorStop(0, "rgba(0, 255, 0, .125)");
                        gradient.addColorStop(1, "rgba(0, 255, 0, 0.0)");
                        return gradient;
                    },
                    cubicInterpolationMode: "monotone",
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                },
                tooltip: {
                    enabled: false,
                },
            },
            layout: {
                padding: {
                    left: -10,
                    bottom: -10,
                },
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                    },
                    ticks: {
                        display: false,
                    },
                    type: "realtime",
                    beginAtZero: true,
                    realtime: {
                        duration: 25000,
                        refresh: 2000,
                        delay: 2000,
                        onRefresh: function (chart) {
                            chart.data.datasets.forEach(function (dataset) {
                                var lastDataPoint =
                                    dataset.data[dataset.data.length - 1];
                                var newX = lastDataPoint
                                    ? lastDataPoint.x + 10000
                                    : Date.now();
                                dataset.data.push({
                                    x: newX,
                                    y: Math.random() * (5 - 1) + 1,
                                });
                            });
                        },
                    },
                },
                y: {
                    min: 1,
                    max: 5,
                    beginAtZero: true,
                    type: "linear",
                    grid: {
                        display: false,
                    },
                    ticks: {
                        display: false,
                    },
                },
            },
        },
        plugins: [backgroundPlugin, glowPlugin],
    });
});
