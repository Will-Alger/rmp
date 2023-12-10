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
        $schoolAverages = getQualityTrend();
        $computerScienceAverages = getQualityTrend("Computer Science");
        $englishAverages = getQualityTrend("English");
        $mathematicsAverages = getQualityTrend("Mathematics");
        $historyAverages = getQualityTrend("History");
        return view('dashboard', compact('schoolAverages', 'computerScienceAverages', 'englishAverages', 'mathematicsAverages', 'historyAverages'));
    }
}
function getColors()
{
    return ['#6871FA', '#F80053', '#FEA25B', '#AB64FA', '#00CE96', '#17D3F4'];
}

function getQualityTrend($subject = null)
{
    return Cache::remember($subject ? $subject . '_quality_charts' : 'university_school_quality_charts', Carbon::now()->addMonth(), function () use ($subject) {
        $schools = School::where('state', 'KY')
            ->orderBy('numRatings', 'desc')
            ->limit(6)
            ->get();
        return new QualityTrend($schools, getColors(), $subject);
    });
}
