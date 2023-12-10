<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Models\School;
use App\Charts\QualityTrend;
use App\Helpers\ReviewHelper;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // $EKU = School::findBy('University of Louisville', 'KY');
        // $EKU_reviews = $helper->getReviews($EKU->id, 2023);
        // $calculated_reviews = $helper->calculateQualityTrend($EKU_reviews);

        // $chart = new SchoolTrend($calculated_reviews, $EKU->name);
        // return view('dashboard', compact('chart'));
        // $charts = [];
        // $schools = School::where('state', 'KY')
        //     ->orderBy('numRatings', 'desc')
        //     ->limit(5)
        //     ->get();

        // foreach ($schools as $school) {
        //     $school_reviews = $helper->getReviews($school->id, 2023);
        //     $calculated_reviews = $helper->calculateQualityTrend($school_reviews);
        //     $chart = new SchoolTrend($calculated_reviews, $school->name);
        //     $charts[$school->name] = $chart;
        // }

        // return view('dashboard', compact('charts'));
        // $universityAverageCharts = Cache::remember('all_school_quality_charts', Carbon::now()->addMonth(), function () {
        //     $helper = new ReviewHelper();
        //     $schools = School::where('state', 'KY')
        //         ->orderBy('numRatings', 'desc')
        //         ->limit(6)
        //         ->get();
        //     $universityAverageCharts = [];
        //     foreach ($schools as $school) {
        //         $school_reviews = $helper->getReviews($school->id, 2023);
        //         $calculated_reviews = $helper->calculateQualityTrend($school_reviews);
        //         $universityAverageCharts[$school->name] = new QualityTrend($calculated_reviews, $school->name, '#39C298');
        //     }
        //     return $universityAverageCharts;
        // });

        // $departmentAverageCharts = Cache::remember('department_school_quality_charts', Carbon::now()->addMonth(), function () {
        //     $helper = new ReviewHelper();
        //     $schools = School::where('state', 'KY')
        //         ->orderBy('numRatings', 'desc')
        //         ->limit(6)
        //         ->get();
        //     $departmentAverageCharts = [];
        //     foreach ($schools as $school) {
        //         $school_reviews = $helper->getReviews($school->id, 2023, "Computer Science");
        //         $calculated_reviews = $helper->calculateQualityTrend($school_reviews);
        //         $departmentAverageCharts[$school->name] = new QualityTrend($calculated_reviews, $school->name, '#F80053');
        //     }
        //     return $departmentAverageCharts;
        // });


        $schoolAverages = Cache::remember('university_school_quality_charts', Carbon::now()->addMonth(), function () {
            $schools = School::where('state', 'KY')
                ->orderBy('numRatings', 'desc')
                ->limit(6)
                ->get();
            return new QualityTrend($schools);
        });

        $computerScienceAverages = Cache::remember('computer_science_quality_charts', Carbon::now()->addMonth(), function () {
            $schools = School::where('state', 'KY')
                ->orderBy('numRatings', 'desc')
                ->limit(6)
                ->get();
            return new QualityTrend($schools, "Computer Science");
        });

        $englishAverages = Cache::remember('english_quality_charts', Carbon::now()->addMonth(), function () {
            $schools = School::where('state', 'KY')
                ->orderBy('numRatings', 'desc')
                ->limit(6)
                ->get();
            return new QualityTrend($schools, "English");
        });

        return view('dashboard', compact('schoolAverages', 'computerScienceAverages', 'englishAverages'));
    }
}
