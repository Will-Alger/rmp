<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\LandingChart;

class LandingController extends Controller
{
    public function index()
    {
        $chart = new LandingChart;
        $chart->labels(['One', 'Two', 'Three', 'Four']);
        $chart->dataset('My dataset', 'line', [1, 2, 3, 4]);
        $chart->dataset('My dataset 2', 'line', [4, 3, 2, 1]);


        return view('landing', compact('chart'));
    }
}
