<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Models\Professor;
use App\Models\School;
use App\Charts\SchoolTrend;

class DashboardController extends Controller
{
    public function index()
    {
        $schools = School::where('state', 'KY')
            ->where('name', '=', "University of Louisville")
            ->orderBy('numRatings', 'desc')
            ->take(1)
            ->get();


        $chart = new SchoolTrend($schools);
        return view('dashboard', compact('chart'));
    }
}
