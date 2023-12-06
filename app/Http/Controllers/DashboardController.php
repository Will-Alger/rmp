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
        $school = School::where('name', 'University of Kentucky')->orderBy('numRatings', 'desc')->first();
        $chart = new SchoolTrend($school);
        return view('dashboard', compact('chart'));
    }
}
