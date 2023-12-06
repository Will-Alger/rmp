<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use App\Models\Professor;
use Carbon\Carbon;

class ReviewTrend extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct(Professor $professor)
    {
        parent::__construct();

        $labels = [];
        $averageQualityRatings = [];
        $averageDifficultyRatings = [];
        $qualityRunningTotal = 0;
        $difficultyRunningTotal = 0;
        $counter = 1;

        $professor->reviews()->orderBy('date')->chunk(200, function ($reviews) use (&$qualityRunningTotal, &$difficultyRunningTotal, &$counter, &$labels, &$averageQualityRatings, &$averageDifficultyRatings) {
            foreach ($reviews as $review) {
                $qualityRunningTotal += (float)$review->qualityRating;
                $difficultyRunningTotal += (float)$review->difficultyRating;

                $temp = $counter++;
                $averageQualityRatings[] = $qualityRunningTotal / $temp;
                $averageDifficultyRatings[] = $difficultyRunningTotal / $temp;

                $labels[] = Carbon::parse($review->date)->format('Y-m');
            }
        });

        $this->labels($labels);

        $this->dataset('Quality Trend', 'line', $averageQualityRatings)
            ->fill(true)
            ->color('#3B37E5')
            ->options([
                'pointRadius' => 0,
            ]);

        $this->dataset('Difficulty Trend', 'line', $averageDifficultyRatings)
            ->fill(true)
            ->color('#E6378B')
            ->options([
                'pointRadius' => 0,
            ]);

        $this->options([
            'animation' => [
                'easing' => 'easeInCubic',
                'duration' => 2000,
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
                'mode' => 'index',
                'intersect' => false,
            ],
        ]);
    }
}
