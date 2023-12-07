<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use App\Models\School;
use App\Models\Review;
use Carbon\Carbon;

class SchoolTrend extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct(Collection $schools)
    {
        parent::__construct();

        $year = Carbon::now()->year;
        $labelsSet = false;

        foreach ($schools as $school) {
            $cacheKey = "school_quality_trend_{$school->id}_{$year}";
            $cacheDuration = Carbon::now()->addMonth();

            [$labels, $monthlyRatings] = Cache::remember($cacheKey, $cacheDuration, function () use ($school, $year) {
                return $this->calculateQualityTrend($school, $year);
            });

            // Set labels only once based on the first school's data
            if (!$labelsSet) {
                $this->labels($labels);
                $labelsSet = true;
            }

            $this->dataset($school->name, 'line', $monthlyRatings)
                ->fill(true)
                ->color($this->getRandomColor()) // Method to generate a random color
                ->options(['pointRadius' => 0]);
        }

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

    private function getRandomColor()
    {
        // Method to generate a random color for each dataset
        // This is just an example. Adjust the implementation as needed.
        return '#' . substr(md5(rand()), 0, 6);
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


        // $reviews = $school->professorReviews()
        //     ->whereYear('date', $year)
        //     ->orderBy('date')
        //     ->get();
        $computerScienceProfessors = $school->professors()
            ->where('department', 'Computer Science')

            ->get();

        $professorIds = $computerScienceProfessors->pluck('id');

        $reviews = Review::whereIn('teacherId', $professorIds)
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
