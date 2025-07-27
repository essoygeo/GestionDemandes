<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Demande;
use App\Models\Ressource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RessourceController extends Controller
{

    public function __construct()
    {
//        dd('test');
    }

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
            'categorie_id' => 'required',
            'nom' => 'required|string',
            'date_ressource' => 'required|date',
            'marque' => 'sometimes|required|string',
            'model' => 'sometimes|required|string'

        ]);

        $validated = $request->validate($rules);

        Ressource::create([
            'categorie_id' => $validated['categorie_id'],
            'user_id' => Auth::id(),
            'nom' => $validated['nom'],
            'date' => $validated['date_ressource'],
            'marque' => $validated['marque'] ?? null,
            'model' => $validated['model'] ?? null,

        ]);

        return redirect()->back()->with('success', 'ressource creée avec succès');
    }

    public function index()
    {

        $ressources = Ressource::with('user', 'categorie','demandes')->paginate(10);
        $categories = Categorie::all();

        return view('ressources.index', compact('ressources','categories'));


    }
    public function update(Request $request,$id)
    {
        $ressource = Ressource::findOrFail($id);
        $rules = ([
            'categorie_id' => 'required',
            'nom' => 'required|string',
            'date_ressource' => 'required|date',


        ]);
             $categorie = $ressource->categorie;
             if (in_array(strtolower($categorie->nom),['logicielle','logicielles','logiciels','logiciel']) ){

                $rules ['marque'] = 'nullable|string';
                $rules ['model'] = 'nullable|string';


                           }

             elseif (in_array(strtolower($categorie->nom),['materielle','materielles','materiels','materiel'])){

                 $rules ['marque'] = 'required|string';
                 $rules ['model'] = 'required|string';

             }
        $validated = $request->validate($rules);

        $ressource->update([
            'categorie_id' => $validated['categorie_id'],
            'user_id' => Auth::id(),
            'nom' => $validated['nom'],
            'date' => $validated['date_ressource'],
            'marque' => $validated['marque'] ?? null,
            'model' => $validated['model'] ?? null,

        ]);

        return redirect()->back()->with('success', 'ressource modifiée avec succès');
    }


    public function destroy($id)
    {
        $ressource = Ressource::findOrFail($id);
        $ressource->delete();
        return redirect()->back()->with('success', 'ressource suprimeé avec succès');
    }
}

