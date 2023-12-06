<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use App\Models\School;
use Carbon\Carbon;

class SchoolTrend extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */

    public function __construct(School $school)
    {
        parent::__construct();

        $year = Carbon::now()->year;
        $labels = [];
        $cumulativeAverages = [];
        $runningTotal = 0;
        $counter = 0;

        $reviews = $school->professorReviews()
            ->whereYear('date', $year)
            ->orderBy('date')
            ->get();

        $currentMonth = null;

        foreach ($reviews as $review) {
            $month = Carbon::parse($review->date)->format('Y-m');
            if ($review->qualityRating !== null) {
                $runningTotal += (float)$review->qualityRating;
                $counter++;
            }

            if ($currentMonth !== $month) {
                if ($currentMonth !== null) {
                    $cumulativeAverages[] = $runningTotal / $counter;
                }
                $labels[] = $month;
                $currentMonth = $month;
            }
        }

        if ($currentMonth !== null && $counter > 0) {
            $cumulativeAverages[] = $runningTotal / $counter;
        }

        $this->labels($labels);

        $this->dataset('School Quality Trend', 'line', $cumulativeAverages)
            ->fill(true)
            ->color('#3B37E5')
            ->options([
                'pointRadius' => 0,
            ]);

        $this->options([
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
        ]);
    }
}
