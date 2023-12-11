<?php

namespace App\Http\Controllers;

use App\Charts\QualityTrend;
use App\Models\Professor;
use Illuminate\Http\Request;
use App\Charts\ReviewTrend;
use App\Helpers\ReviewHelper;
use App\Models\School;
use Illuminate\Support\Facades\Cache;


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
        $helper = new ReviewHelper();

        $reviews = Cache::remember('reviews_' . $professor->id, 60, function () use ($professor) {
            return $professor->reviews()->orderByDesc('date')->paginate(10);
        });

        $chart = Cache::remember('chart_' . $professor->id, 60, function () use ($professor) {
            return new ReviewTrend($professor);
        });

        $school = Cache::remember('school_' . $professor->schoolId, 60, function () use ($professor) {
            return School::where('id', $professor->schoolId)->get();
        });

        // $schoolTrend = Cache::remember('schoolTrend_' . $professor->schoolId, 60, function () use ($school) {
        //     return new QualityTrend($school, ['#6871FA']);
        // });

        $departmentTrend = Cache::remember('departmentTrend_' . $professor->schoolId . '_' . $professor->department, 60, function () use ($helper, $professor, $school) {
            return $helper->getReviews($professor->schoolId, 2023, $professor->department)->count() > 0
                ? new QualityTrend($school, ['#6871FA'], $professor->department)
                : null;
        });


        return view('professor.show', compact('professor', 'chart', 'reviews', 'departmentTrend'));
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
