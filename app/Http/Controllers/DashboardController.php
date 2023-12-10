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
        $schoolAverages = Cache::remember('university_school_quality_charts', Carbon::now()->addMonth(), function () {
            $schools = School::where('state', 'KY')
                ->orderBy('numRatings', 'desc')
                ->limit(6)
                ->get();
            return new QualityTrend($schools, getColors());
        });

        $computerScienceAverages = Cache::remember('computer_science_quality_charts', Carbon::now()->addMonth(), function () {
            $schools = School::where('state', 'KY')
                ->orderBy('numRatings', 'desc')
                ->limit(6)
                ->get();
            return new QualityTrend($schools, getColors(), "Computer Science");
        });

        $englishAverages = Cache::remember('english_quality_charts', Carbon::now()->addMonth(), function () {
            $schools = School::where('state', 'KY')
                ->orderBy('numRatings', 'desc')
                ->limit(6)
                ->get();
            return new QualityTrend($schools, getColors(), "English");
        });

        $mathematicsAverages = Cache::remember('mathematics_quality_charts', Carbon::now()->addMonth(), function () {
            $schools = School::where('state', 'KY')
                ->orderBy('numRatings', 'desc')
                ->limit(6)
                ->get();
            return new QualityTrend($schools, getColors(), "Mathematics");
        });

        $historyAverages = Cache::remember('history_quality_charts', Carbon::now()->addMonth(), function () {
            $schools = School::where('state', 'KY')
                ->orderBy('numRatings', 'desc')
                ->limit(6)
                ->get();
            return new QualityTrend($schools, getColors(), "History");
        });

        return view('dashboard', compact('schoolAverages', 'computerScienceAverages', 'englishAverages', 'mathematicsAverages', 'historyAverages'));
    }
}
function getColors()
{
    return ['#6871FA', '#F80053', '#FEA25B', '#AB64FA', '#00CE96', '#17D3F4'];
}
