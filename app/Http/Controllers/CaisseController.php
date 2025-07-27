<?php

namespace App\Http\Controllers;

use App\Models\Caisse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CaisseController extends Controller
{
//   public function create()
//   {
//       return view('caisses.create');
//   }


////    public function store(Request $request)
////    {
////        if(Caisse::exists()){
////            return back()->with('error','Une caisse existe déjà. Vous ne pouvez en créer qu\'une seule.');
////        }
////
////
////        $validated = $request->validate([
////            'montant_init' => 'required|numeric|min:0',
////            'date' => 'required|date',
////        ]);
////
////        Caisse::create([
////            'user_id'=>Auth::id(),
////            'montant_init' => $validated['montant_init'],
////            'montant_actuel' => $validated['montant_init'],
////            'date' => $validated['date'],
////        ]);
//
//        return redirect()->route('index.caisse')->with('success', 'caisse créee avec sucess');
//    }

    public function index()
    {
        $caisse = Caisse::first();


        return view('caisses.create',compact('caisse'));
    }
    public function update(Request $request,$id)
    {

        $caisse = Caisse::findOrFail($id);

        $validated = $request->validate([
            'montant_init' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        $caisse->update([
            'user_id'=>Auth::id(),
            'montant_init' => $validated['montant_init'],
            'date' => $validated['date'],
        ]);

        return redirect()->route('index.caisse')->with('success', 'caisse chargée avec sucess');
    }
}
