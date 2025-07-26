<?php

namespace App\Http\Controllers;

use App\Models\Caisse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CaisseController extends Controller
{
   public function create()
   {
       return view('caisses.create');
   }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'montant_init' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        Caisse::create([
            'user_id'=>Auth::id(),
            'montant_init' => $validated['montant_init'],
            'montant_actuel' => $validated['montant_init'],
            'date' => $validated['date'],
        ]);

        return redirect()->route('create.caisse')->with('success', 'caisse créee avec sucess');
    }
}
