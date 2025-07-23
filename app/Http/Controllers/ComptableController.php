<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComptableController extends Controller
{
    public function comptableDashboard()
    {
        return view('dashboard.dashboard');
    }
}
