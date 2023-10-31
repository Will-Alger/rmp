<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Models\Professor;


class CompareController extends Controller
{
    public function index()
    {
        return view('compare');
    }
}
