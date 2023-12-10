<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use App\Models\School;
use App\Models\Review;
use Carbon\Carbon;

class QualityTrend extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct(array $calculated_reviews, string $name, string $dataColor = null)
    {
        parent::__construct();
        $this->labels = collect($calculated_reviews[0])->map(function ($label) {
            return Carbon::parse($label)->format('m');
        })->toArray();
        $reviews = $calculated_reviews[1];

        $this->dataset("{$name}", 'line', $reviews)
            ->fill(true)
            ->color($dataColor ?? $this->getRandomColor())

            ->options(['pointRadius' => 0]);

        $this->options([
            'legend' => [
                'display' => false,
            ],
            'layout' => [
                'padding' => [
                    'left' => 5 // Adjust the number to increase or decrease padding
                ],
            ],
            'scales' => [
                'yAxes' => [
                    [
                        'ticks' => [
                            'min' => 1,
                            'max' => 5,
                        ],
                    ],
                ],
            ],
            'tooltips' => [
                'enabled' => true,
                'mode' => 'index',
                'intersect' => false,
            ],
        ]);
    }

    private function getRandomColor()
    {
        return '#' . substr(md5(rand()), 0, 6);
    }
}
