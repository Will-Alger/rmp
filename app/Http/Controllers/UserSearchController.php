<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Models\Professor;


class UserSearchController extends Controller
{
    public function index()
    {
        return view('user_search');
    }
}
