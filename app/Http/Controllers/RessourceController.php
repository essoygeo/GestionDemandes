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
                        'no_estimation' => 'nullable|boolean',
            'estimation_montant' => $request->no_estimation
                ? 'nullable'
                : 'required|numeric|min:0',
            'marque' => 'sometimes|required|string',
            'model' => 'sometimes|required|string'

        ]);

        $validated = $request->validate($rules);

        Ressource::create([
            'categorie_id' => $validated['categorie_id'],
            'user_id' => Auth::id(),
            'nom' => $validated['nom'],
            'marque' => $validated['marque'] ?? null,
            'model' => $validated['model'] ?? null,
            'status'=>'A payer',
            'estimation_montant' => $validated['estimation_montant'] ?? null,

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
            'estimation_montant' => $request->no_estimation
                ? 'nullable'
                : 'required|numeric|min:0',



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
            'marque' => $validated['marque'] ?? null,
            'model' => $validated['model'] ?? null,

            'estimation_montant' => $validated['estimation_montant'] ?? null,

        ]);

        return redirect()->back()->with('success', 'ressource modifiée avec succès');
    }


    public function destroy($id)
    {
        $ressource = Ressource::findOrFail($id);
        $ressource->delete();
        return redirect()->back()->with('success', 'ressource suprimeé avec succès');
    }


    public function changeStatus(Request $request,$id)
    {
        $ressource = Ressource::findOrFail($id);
         $ressource->status = $request->nouveau_status;
        $ressource->save();

        return back()->with('success', 'Statut de la ressource mis à jour.');
    }

    public function updateMontant(Request $request,$id)
    {
        $ressource = Ressource::findOrFail($id);
        $ressource->estimation_montant = $request->estimation_montant;
        $ressource->save();

        return back()->with('success', 'montant mise à jour de la ressource.');
    }
}

