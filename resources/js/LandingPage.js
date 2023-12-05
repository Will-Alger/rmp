import Chart from "chart.js/auto";
import { DateTime } from "luxon";
import "chartjs-adapter-luxon";
import ChartStreaming from "chartjs-plugin-streaming";
Chart.register(ChartStreaming);

function generateInitialData(dataPoints) {
    var data = [];
    for (var i = 0; i < dataPoints; i++) {
        data.push({
            x: Date.now() - (dataPoints - i) * 10000,
            y: Math.random() * (3 - 1.5) + 1.5,
        });
    }
    return data;
}

function loadDataFromStorage(key) {
    try {
        var data = localStorage.getItem(key);
        return data ? JSON.parse(data) : null;
    } catch (e) {
        console.error("Error loading chart data: ", e);
        return null;
    }
}

document.addEventListener("DOMContentLoaded", () => {
    var ctx = document.getElementById("myChart").getContext("2d");
    var savedData = loadDataFromStorage("chartData");
    var secondData = savedData ? savedData[0].data : generateInitialData(100);

    const backgroundPlugin = {
        id: "customCanvasBackgroundColor",
        beforeDraw: (chart) => {
            const ctx = chart.ctx;
            const { top, left, width, height } = chart.chartArea;
            ctx.save();
            ctx.fillStyle = "#161619";
            ctx.fillRect(left, top, width, height);
            const dotSize = 0.5;
            const spacing = 75;
            ctx.fillStyle = "#E2E2E3";
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
                    data: secondData,
                    borderColor: "#39C298",
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: "#39C298",
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
                        gradient.addColorStop(0, "rgba(57, 194, 152, 0.75)");
                        gradient.addColorStop(1, "rgba(57, 194, 152, 0)");
                        return gradient;
                    },
                    cubicInterpolationMode: "default",
                },
            ],
        },
        options: {
            animation: false,
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
                        duration: 100000,
                        refresh: 1000,
                        delay: 0,
                        onRefresh: function (chart) {
                            chart.data.datasets.forEach(function (dataset) {
                                var lastDataPoint =
                                    dataset.data[dataset.data.length - 1];
                                var newX = lastDataPoint
                                    ? lastDataPoint.x + 10000
                                    : Date.now();
                                dataset.data.push({
                                    x: newX,
                                    y: Math.random() * (3 - 1.5) + 1.5,
                                });
                            });
                            localStorage.setItem(
                                "chartData",
                                JSON.stringify(chart.data.datasets)
                            );
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
