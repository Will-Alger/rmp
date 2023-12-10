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
    public function __construct(Collection $schools, ?string $department = null)
    {
        parent::__construct();

        $currentMonth = Carbon::now()->month;
        $this->labels = collect(range(1, $currentMonth))->map(function ($month) {
            return Carbon::createFromDate(null, $month, null)->format('m');
        })->toArray();

        $labels = collect(range(1, $currentMonth))->map(function ($month) {
            return Carbon::createFromDate(null, $month, null)->format('m');
        })->toArray();

        // $this->labels = collect($calculated_reviews[0])->map(function ($label) {
        //     return Carbon::parse($label)->format('m');
        // })->toArray();

        $helper = new ReviewHelper();
        foreach ($schools as $school) {
            $school_reviews = $helper->getReviews($school->id, 2023, $department);
            $calculated_reviews = $helper->calculateQualityTrend($school_reviews, $labels);

            $this->dataset($school->name, 'line', $calculated_reviews)
                ->fill(true)
                ->color($this->getRandomColor())
                ->options(['pointRadius' => 0]);
        }





        // $reviews = $calculated_reviews[1];

        // $this->dataset("{$name}", 'line', $reviews)
        //     ->fill(true)
        //     ->color($dataColor ?? $this->getRandomColor())

        //     ->options(['pointRadius' => 0]);

        $this->options([
            'legend' => [
                'display' => true,
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

    // private function getRandomColor()
    // {
    //     return '#' . substr(md5(rand()), 0, 6);
    // }
    private function getRandomColor()
    {
        // Randomly choose between color ranges for pink/red, blue, and purple
        switch (rand(1, 3)) {
            case 1: // Pink/Red
                $red = rand(180, 255);
                $green = rand(0, 100);
                $blue = rand(0, 100);
                break;
            case 2: // Blue
                $red = rand(0, 100);
                $green = rand(0, 100);
                $blue = rand(180, 255);
                break;
            case 3: // Purple
                $red = rand(100, 255);
                $green = rand(0, 80);
                $blue = rand(100, 255);
                break;
        }

        // Convert to hexadecimal and return
        return sprintf("#%02x%02x%02x", $red, $green, $blue);
    }
}
