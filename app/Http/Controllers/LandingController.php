<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\LandingChart;

class LandingController extends Controller
{
    public function index()
    {
        return view('landing');
    }
}
