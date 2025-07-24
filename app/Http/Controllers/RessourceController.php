<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Demande;
use App\Models\Ressource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RessourceController extends Controller
{
//    public function create($demande= null)
//    {
//
//
//        if ($demande) {
//            $demandeSelectione = Demande::find($demande);
//        }
//        else{
//            $demandeSelectione= null;
//        }
//
//        $demandes = Demande::where('status','En attente')->get();
//        return view('demandes.create',[
//            'demandes'=>$demandes,
//            'demandeSelectione'=>$demandeSelectione
//
//        ]);
//    }

    public function store(Request $request)
    {
        $rules = ([
            'demande_id' => 'required|exists:demandes,id',
            'nom' => 'required|string',
            'date_ressource' => 'required|date',
            'marque'=>'sometimes|required|string',
            'model'=>'sometimes|required|string'

        ]);

        $validated = $request->validate($rules);

         Ressource::create([
            'user_id' => Auth::id(),
            'demande_id' => $validated['demande_id'],
            'nom' => $validated['nom'],
            'date' => $validated['date_ressource'],
             'marque'=>$validated['marque']?? null,
             'model'=>$validated['model'] ?? null,

        ]);

        return redirect()->back()->with('success', 'ressource creée avec succès');
    }
}
