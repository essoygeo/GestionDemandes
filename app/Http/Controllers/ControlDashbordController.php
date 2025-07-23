<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControlDashbordController extends Controller
{
    //

    function index(Request $request)
    {
        $role = Auth::user()->role;




        switch ($role) {
            case'Admin':
               return redirect()->route('admin.dashboard');
            case'Comptable':
                return  redirect()->route('comptable.dashboard');
            case'Employe':
               return redirect()->route('employe.dashboard');
            default:
                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect('/login');
        }

    }
}
