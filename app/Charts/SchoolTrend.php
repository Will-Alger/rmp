<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Illuminate\Support\Facades\Cache;
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
        $cacheKey = "school_quality_trend_{$school->id}_{$year}";
        $cacheDuration = Carbon::now()->addMonth();

        [$labels, $monthlyRatings] = Cache::remember($cacheKey, $cacheDuration, function () use ($school, $year) {
            return $this->calculateQualityTrend($school, $year);
        });

        $this->labels($labels);
        $this->dataset("{$school->name}", 'line', $monthlyRatings)
            ->fill(true)
            ->color('#3B37E5')
            ->options(['pointRadius' => 0]);

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

    /**
     * Calculates the average monthly quality ratings for professor reviews within a given year for a specific school.
     *
     * @param School $school The school for which to calculate the quality trend.
     * @param int $year The year for which to calculate the quality trend.
     *
     * @return array An array containing two arrays:
     *  * `labels`: An array of month strings in the format "YYYY-MM".
     *  * `monthlyRatings`: An array of average quality ratings for each corresponding month.
     */
    public function calculateQualityTrend(School $school, $year)
    {
        $labels = [];
        $monthlyRatings = [];
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
                    $monthlyRatings[] = $runningTotal / $counter;
                }
                $labels[] = $month;
                $currentMonth = $month;
            }
        }
        if ($currentMonth !== null && $counter > 0) {
            $monthlyRatings[] = $runningTotal / $counter;
        }
        return [$labels, $monthlyRatings];
    }
}
