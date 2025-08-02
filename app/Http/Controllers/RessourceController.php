<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Demande;
use App\Models\Ressource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    public function update(Request $request, $ressourceId, $pivotId)
    {
        $ressource = Ressource::findOrFail($ressourceId);

        //  Gérer no_estimationX
        $noEstimationField = 'no_estimation' . $pivotId;
        $noEstimationValue = $request->input($noEstimationField, '0');
        $noEstimation = $noEstimationValue == '1'; // true si coché

        // Définir les règles de validation
        $rules = [
            'categorie_id' => 'required',
            'nom' => 'required|string',
            'estimation_montant' . $pivotId => $noEstimation
                ? 'nullable'           // si coché → pas obligatoire
                : 'required|numeric|min:0', // sinon → obligatoire
        ];

        $categorie = $ressource->categorie;

        if (in_array(strtolower($categorie->nom), ['logicielle', 'logicielles', 'logiciels', 'logiciel'])) {
            $rules['marque'] = 'nullable|string';
            $rules['model'] = 'nullable|string';
        } elseif (in_array(strtolower($categorie->nom), ['materielle', 'materielles', 'materiels', 'materiel'])) {
            $rules['marque'] = 'required|string';
            $rules['model'] = 'required|string';
        }

        //  Valider les données
        $validated = $request->validate($rules);


        //  Déterminer la valeur de estimation_montant
        //      → Si case cochée : forcer à null
        //      → Sinon : prendre la valeur soumise



        //  5. Mettre à jour la ressource
        $ressource->update([
            'categorie_id' => $validated['categorie_id'],
            'user_id' => Auth::id(),
            'nom' => $validated['nom'],
            'marque' => $validated['marque'] ?? null,
            'model' => $validated['model'] ?? null,
        ]);

        //  6. Mettre à jour le champ dans la table pivot
        DB::table('demandes_pivot_ressources')
            ->where('id', $pivotId)
            ->update([
                'estimation_montant' => $request->input('estimation_montant' . $pivotId) ?? null,
            ]);

        return redirect()->back()->with('success', 'Ressource modifiée avec succès');
    }


    public function destroy($id)
    {
        $ressource = Ressource::findOrFail($id);
        $ressource->delete();
        return redirect()->back()->with('success', 'ressource suprimeé avec succès');
    }


    public function changeStatus(Request $request,$pivotId)
    {
//        $demande = Demande::findOrFail($demandeId);
//         $demande->ressources()->updateExistingPivot($ressourceId,[
//            'status'=>$request->nouveau_status,
//        ]);

        DB::table('demandes_pivot_ressources')->where('id', $pivotId)->update([
            'status' => $request->nouveau_status,

        ]);

        return back()->with('success', 'Statut de la ressource mis à jour.');
    }

    public function updateMontant(Request $request,$pivotId)
    {
        DB::table('demandes_pivot_ressources')->where('id', $pivotId)->update([
            'estimation_montant' => $request->estimation_montant,

        ]);
        //dd($request->estimation_montant);





        return back()->with('success', 'montant mise à jour de la ressource.');
    }
}

