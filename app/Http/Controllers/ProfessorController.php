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
        $professor->load('reviews');

        $datesAndRatings = $professor->reviews()->orderBy('date')->get();

        $labels = [];
        $averageQualityRatings = [];
        $runningTotal = 0;

        foreach ($datesAndRatings as $index => $review) {
            $runningTotal += (float)$review->qualityRating;
            $averageQualityRatings[] = $runningTotal / ($index + 1); // calculating average
            $labels[] = \Carbon\Carbon::parse($review->date)->format('Y-m');
        }

        $chart = new ReviewTrend;

        $chart->labels($labels);
        $dataset = $chart->dataset('Quality Trend', 'line', $averageQualityRatings)
            ->fill(true)
            ->options([
                'pointRadius' => 0,
            ]);
        $dataset->color('#1F1BCE');

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

        return view('professor.show', compact('professor', 'chart'));
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
