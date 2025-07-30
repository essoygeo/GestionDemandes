<?php

namespace App\Http\Controllers;

use App\Models\Caisse;
use App\Models\Categorie;
use App\Models\Demande;
use App\Models\Ressource;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DemandeController extends Controller
{
    public function create(Request $request)
    {
        $ressources = Ressource::all();
        $categories = Categorie::all();
        //$demandes = Demande::where('status', 'En attente')->get();
        //$demandeSelectione = null;
//        if ($request->has('demande_id')) {
//            $demandeSelectione = Demande::find($request->demande_id);
//        }

        return view('demandes.create', compact('categories', 'ressources'));
    }

    public function store(Request $request)
    {
        $rules = ([

            'titre' => 'required|string',
            'raison' => 'required|string',
//            'no_estimation' => 'nullable|boolean',
//            'estimation_montant' => $request->no_estimation
//                ? 'nullable'
//                : 'required|numeric|min:0',
            'ressources' => 'required|array',
            'ressources.*' => 'exists:ressources,id',

        ]);

//        if ($request->type === 'En stock') {
//            $rules['estimation_montant'] = 'nullable';
//        } else {
//            $rules['estimation_montant'] = 'required|numeric|min:0';
//        }
        $validated = $request->validate($rules);

        $demande = Demande::create([
            'user_id' => Auth::id(),
            'titre' => $validated['titre'],
            'raison' => $validated['raison'],
//            'estimation_montant' => $validated['estimation_montant'] ?? null,

        ]);

        //$route = Auth::user()->role ==='Employe' ? 'indexEmploye.demandes' : 'index.demandes';

//        return redirect()->route($route)
//            ->with('warning','veuillez creer la/les ressources associée(s) à cette demande')
//        ->with('success', 'demande créee avec sucess');

        $pivotData = [];
        foreach ($validated['ressources'] as $ressourceId) {
            $ressource = Ressource::findOrFail($ressourceId);
//            $pivotData[$ressourceId] = [
//                'status' => $ressource->status,
//                'estimation_montant' => $ressource->estimation_montant
//            ];
            $demande->ressources()->attach([
                $ressourceId=>[
                    'status' => $ressource->status,
                    'estimation_montant' => $ressource->estimation_montant
                ]
            ]);

        }


//        $demande->ressources()->attach($pivotData);
//        dd($pivotData,$demande,$demande->ressources()->get());


        return redirect()->route('create.demandes')->with('success', 'Demande créee avec succès');


    }

    public function index()

    {


        $demandes = Demande::with('user')->paginate(10);

        if (Auth::user()->role === 'Employe') {
            return redirect()->route('indexEmploye.demandes');
        }

        return view('demandes.index', compact('demandes'));


    }

    public function show($id)

    {
        $categories = Categorie::all();
        $demande = Demande::with(['user', 'categorie', 'ressources.user', 'ressources.categorie', 'commentaires.user'])->findOrFail($id);
        $ressources = $demande->ressources;
        $montantRessources = $ressources->sum(function ($ressource) {
            return $ressource->pivot->estimation_montant;
        });
        $caisse_mtn_actuel = Caisse::first()->montant_init;
//        if(!empty($demande->estimation_montant)) {
//            // estimation existe et n'est pas nulle/0/""/false
//            if($caisse_mtn_actuel > $demande->estimation_montant){
//                if($demande->status === 'En attente'){
//                    session()->flash('success','le montant de la caisse couvre estimation');
//                }
//            }
//            elseif($caisse_mtn_actuel < $demande->estimation_montant){
//                session()->flash('error','le montant de la caisse ne couvre pas l\'estimation');
//            }
//            else{
//                session()->flash('info','le montant de la caisse est égal à l\'estimation');
//            }
//        } else {
//            session()->flash('info','Pas d\'estimation pour cette demande');
//        }


        return view('demandes.show', compact('demande', 'ressources', 'categories', 'caisse_mtn_actuel', 'montantRessources'));
    }

    public function destroy($id)
    {
        $demande = Demande::findOrFail($id);
        $demande->delete();

        //$route = Auth::user()->role ==='Employe' ? 'indexEmploye.demandes' : 'index.demandes';
        //return redirect()->route($route)->with('success', 'demande suprimée avec sucess');

        return redirect()->back()->with('success', 'Demande supprimée avec succès');
    }

    public function edit($id)
    {
        $demande = Demande::findOrFail($id);

        $ressources = Ressource::all(); // toutes les ressources
        $ressourcesActuelles = $demande->ressources()->pluck('ressources.id')->toArray(); // les ID associés

        return view('demandes.edit', compact('demande', 'ressources', 'ressourcesActuelles'));
    }


    public function update(Request $request, $id)
    {
        $rules = [
            // 'categorie_id' => 'required',

            'titre' => 'required|string',
            'raison' => 'required|string',
            'no_estimation' => 'nullable|boolean',
            'ressources' => 'required|array',
            'ressources.*' => 'exists:ressources,id',
        ];

//        if ($request->type === 'En stock') {
//            $rules['estimation_montant'] = 'nullable';
//        } else {
//            $rules['estimation_montant'] = 'required|numeric|min:0';
//        }

        $validated = $request->validate($rules);

        $demande = Demande::findOrFail($id); // ← on récupère la demande

        $demande->update([
            'user_id' => Auth::id(),
            //'categorie_id' => $validated['categorie_id'],
            'titre' => $validated['titre'],
            'raison' => $validated['raison'],
//            'estimation_montant' => $validated['estimation_montant'] ?? null,

        ]);

        foreach ($validated['ressources'] as $ressourceId) {
            $ressource = Ressource::findOrFail($ressourceId);
            $demande->ressources()->updateExistingPivot($ressource->id,
                [
                    'status' => $ressource->status,
                    'estimation_montant' => $ressource->estimation_montant
                ]
            );

        }


        //$route = Auth::user()->role ==='Employe' ? 'indexEmploye.demandes' : 'index.demandes';

        //return redirect()->route($route)->with('success', 'Demande modifiée avec succès');

        return redirect()->back()->with('success', 'Demande modifiée avec succès');


    }

    public function indexUserDemande()
    {
        $user = Auth::user();
        $demandes = $user->demandes()->with('categorie')->paginate(10);

        return view('demandes.index_user', compact('demandes'));
    }


    public function valider(Request $request, $id)
    {
        $caisse = Caisse::first();
        $demande = Demande::findOrFail($id);
        $ressources = $demande->ressources;
        $montantRessources = $ressources
            ->filter(function ($ressource) {
                return $ressource->pivot->status === 'payer';
            })
            ->sum(function ($ressource) {
                return $ressource->pivot->estimation_montant;
            });

        $allressourcesNonPayable = $ressources
            ->every(function ($ressource) {
                return $ressource->pivot->status === 'Ne sera pas payé';
            });

        if ($demande->status === 'En attente') {
            if ($caisse->montant_init > $montantRessources) {

                // Vérifie s'il reste des ressources non encore traitées
                foreach ($ressources as $ressource) {
                    if ($ressource->pivot->status === 'A payer') {
                        return redirect()->back()->with('error', 'Veuillez traiter toutes les ressources avant de valider refuser!');
                    }
                }
                //si tous les staatus sont ne sera pas payé impossile de valider mais que refusé
                if ($allressourcesNonPayable) {
                    return redirect()->back()->with('error', 'Vous ne pouvez pas valider cette demande car toutes les ressources ont le statut "Ne sera pas payé". Veuillez la refuser.');

                }
                // Toutes les ressources sont traitées, on peut créer les transactions pour ceux payer
                foreach ($ressources as $ressource) {
                    if ($ressource->pivot->status === 'Payer') {
                        Transaction::create([
                            'user_id' => Auth::id(),
                            'caisse_id' => $caisse->id,
                            'demande_id' => $demande->id,
                            'montant_transaction' => $ressource->pivot->estimation_montant,
                            'type' => 'Sortie',
                            'motif' => 'Sortie du montant de caisse à cause de la ressource #' . $ressource->id,
                        ]);
                    }

                }

                $caisse->montant_init -= $montantRessources;
                $caisse->save();

                $demande->status = 'Validé';
                $demande->save();

                return redirect()->route('index.demandes')->with('success', 'Demande validée avec succès.');
            } else {
                return redirect()->back()->with('error', 'Montant de la caisse insuffisant !');
            }
        }

        return redirect()->back()->with('error', 'Demande déjà traitée.');
    }

    public function refuser(Request $request, $id)
    {
        $demande = Demande::findOrFail($id);
//        $resources = $demande->ressources;
        if ($demande->status === 'En attente') {
//            foreach ($resources as $resource) {
//                if ($resource->status === 'A payer') {
//                    return redirect()->back()->with('error', 'Veuillez traiter toutes les ressources avant de valider ou refuser !');
//                }
//            }
            $demande->status = 'Refusé';
            $demande->save();
            return redirect()->route('index.demandes')->with('success', 'Demande refusée avec succès.');

        }
        return redirect()->back()->with('error', 'Demande déjà traitée.');

    }

}
