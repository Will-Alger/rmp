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
        $this->labels = $calculated_reviews[0];
        $reviews = $calculated_reviews[1];

        // foreach ($schools as $school) {
        //     $cacheKey = "school_quality_trend_{$school->id}_{$year}";
        //     $cacheDuration = Carbon::now()->addMonth();

        //     [$labels, $monthlyRatings] = Cache::remember($cacheKey, $cacheDuration, function () use ($school, $year) {
        //         return $this->calculateQualityTrend($school, $year);
        //     });

        //     // Set labels only once based on the first school's data
        //     if (!$labelsSet) {
        //         $this->labels($labels);
        //         $labelsSet = true;
        //     }

        $this->dataset("{$name}", 'line', $reviews)
            ->fill(true)
            ->color($dataColor ?? $this->getRandomColor())
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
