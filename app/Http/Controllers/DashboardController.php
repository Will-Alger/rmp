<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Models\Professor;

class DashboardController extends Controller
{
    public function index() {
//        $professor = (new \App\Models\Professor)->find("VGVhY2hlci0xMTA=");
//        $professor = Professor::query()->find("VGVhY2hlci0xMTA=");
//        , compact('professor')
        return view('dashboard');
    }
}
