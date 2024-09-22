<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        return view('home.index');
    }
}//
