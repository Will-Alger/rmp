<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use App\Models\School;
use App\Models\Review;
use App\Helpers\ReviewHelper;
use Carbon\Carbon;

class QualityTrend extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct(Collection $schools, array $colors, ?string $department = null)
    {
        parent::__construct();

        $currentMonth = Carbon::now()->month;
        $labels = collect(range(1, $currentMonth))->map(function ($month) {
            return Carbon::createFromDate(null, $month, null)->format('m');
        })->toArray();
        $this->labels = $labels;

        $helper = new ReviewHelper();
        $i = 0;
        foreach ($schools as $school) {
            $school_reviews = $helper->getReviews($school->id, 2023, $department);
            $calculated_reviews = $helper->calculateQualityTrend($school_reviews, $labels);

            $this->dataset($school->name, 'line', $calculated_reviews)
                ->fill(true)
                ->color($colors[$i])
                ->options(['pointRadius' => 0]);
            $i++;
        }

        $this->options([
            'legend' => [
                'display' => true,
            ],
            'layout' => [
                'padding' => [
                    'left' => 5
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
}
