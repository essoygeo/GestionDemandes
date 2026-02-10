<?php

namespace App\Http\Controllers;

use App\Models\Caisse;
use App\Models\Transaction;
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
////
////        ]);
////
////        Caisse::create([
////            'user_id'=>Auth::id(),
////            'montant_init' => $validated['montant_init'],
////            'montant_actuel' => $validated['montant_init'],
////
////        ]);
//
//        return redirect()->route('index.caisse')->with('success', 'caisse créee avec sucess');
//    }

    public function index()
    {
        $caisse = Caisse::first();
        $transactions = Transaction::with('demande')->paginate(10);

        return view('caisses.create', compact('caisse','transactions'));
    }

    public function update(Request $request, $id)
    {
        $caisse = Caisse::findOrFail($id);

        $validated = $request->validate([
            'montant_init' => 'required|numeric|min:0',
        ]);


        $montant = $caisse->montant_init;

        if ($caisse && $validated['montant_init'] >0 ) {
            $caisse->update([
                'montant_init' => $validated['montant_init'] + $montant,

            ]);


            Transaction::create([
                'user_id' => Auth::id(),
                'montant_transaction' => $validated['montant_init'],
                'type' => 'Entree',
                'motif' => 'Entrée du montant de caisse',

            ]);

            return redirect()->route('index.caisse')
                ->with('success', 'montant ajouté avec succès');

        }

        return redirect()->route('index.caisse')
            ->with('error', 'Assurez-vous que le montant est supérieur à zéro. !');

    }



}
