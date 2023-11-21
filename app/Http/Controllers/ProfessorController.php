<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use Illuminate\Http\Request;
use App\Charts\ReviewTrend;

class ProfessorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Professor $professor)
    {
        $reviews = $professor->reviews()->orderByDesc('date')->paginate(10);

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


                $labels[] = \Carbon\Carbon::parse($review->date)->format('Y-m');
            }
        });

        $chart = new ReviewTrend;

        $chart->labels($labels);
        $qualityDataSet = $chart->dataset('Quality Trend', 'line', $averageQualityRatings)
            ->fill(true)
            ->options([
                'pointRadius' => 0,
            ]);
        $qualityDataSet->color('#3B37E5');

        $difficultyDataSet = $chart->dataset('Difficulty Trend', 'line', $averageDifficultyRatings)
            ->fill(true)
            ->options([
                'pointRadius' => 0,
            ]);
        $difficultyDataSet->color('#E6378B');

        $chart->options([
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
                        ]
                    ]
                ]
            ],
            'tooltips' => [
                'mode' => 'index',
                'intersect' => false,
            ],
        ]);

        return view('professor.show', compact('professor', 'chart', 'reviews'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Professor $professor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Professor $professor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Professor $professor)
    {
        //
    }
}
