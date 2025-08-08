<?php

namespace App\Http\Controllers;

use App\Models\Caisse;
use App\Models\Categorie;
use App\Models\Demande;
use App\Models\Notification;
use App\Models\Ressource;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        $users = User::whereIn('role', ['Admin', 'Comptable'])->get();

        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'message' => 'une demande vient d\'etre créee',

            ]);
        }

        //$route = Auth::user()->role ==='Employe' ? 'indexEmploye.demandes' : 'index.demandes';
//        $user= Auth::user();
        $url = route("message.index", ['demande' => $demande->id]);
        envoyerMail($users, 'Une demande vient d\'etre créee !', 'Une demande vient d\'etre créee !', $url);


//        return redirect()->route($route)
//            ->with('warning','veuillez creer la/les ressources associée(s) à cette demande')
//        ->with('success', 'demande créee avec sucess');

//        $pivotData = [];
        foreach ($validated['ressources'] as $ressourceId) {
            $ressource = Ressource::findOrFail($ressourceId);
//            $pivotData[$ressourceId] = [
//                'status' => $ressource->status,
//                'estimation_montant' => $ressource->estimation_montant
//            ];
//            $demande->ressources()->attach([
//                    'status' => $ressource->status,
//                    'estimation_montant' => $ressource->estimation_montant
//                ]
//            ]);

            DB::table('demandes_pivot_ressources')->insert([
                'demande_id' => $demande->id,
                'ressource_id' => $ressource->id,
                'status' => $ressource->status,
                'estimation_montant' => $ressource->estimation_montant,

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

        $curentuser = Auth::user();
        if( $demande->user_id !== $curentuser->id && $curentuser->role =='Employe' ){
            abort(403,'Acces non autorisé');


        }
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

        $factures = $demande->factures()->get();

        return view('demandes.show', compact('demande', 'ressources', 'categories', 'factures', 'caisse_mtn_actuel', 'montantRessources'));
    }

    public function destroy($id)
    {
        $demande = Demande::findOrFail($id);
        $demande->delete();

        $users = User::whereIn('role', ['Admin', 'Comptable'])->get();
       $current = Auth::user();
        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'message' => "la demande #{$id}  a été suprimée par  l'utilisateur {$current->nom}",

            ]);
        }

        //$route = Auth::user()->role ==='Employe' ? 'indexEmploye.demandes' : 'index.demandes';
        //return redirect()->route($route)->with('success', 'demande suprimée avec sucess');

        return redirect()->back()->with('success', 'Demande supprimée avec succès');
    }

    public function edit($id)
    {
        $demande = Demande::findOrFail($id);
        $curentuser = Auth::user();
        if( $demande->user_id !== $curentuser->id && $curentuser->role !=='Admin' ){
            abort(403,'Acces non autorisé');


        }
        elseif($demande->status !== 'En attente'){
                   return redirect()->back()->with('error','Demande deja traitée Aucune modification n\'est autorisée !');
        }

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


        $demande->ressources()->sync($validated['ressources']);
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
                return $ressource->pivot->status === 'Payer';
            })
            ->sum(function ($ressource) {
                return $ressource->pivot->estimation_montant;
            });

        $allressourcesNonPayable = $ressources
            ->every(function ($ressource) {
                return $ressource->pivot->status === 'Ne sera pas payé';
            });

        if ($demande->status === 'En attente') {
            if ($caisse->montant_init >= $montantRessources) {

                // Vérifie s'il reste des ressources non encore traitées
                foreach ($ressources as $ressource) {
                    if ($ressource->pivot->status === 'A payer') {
                        return redirect()->back()->with('error', 'Veuillez traiter toutes les ressources avant de valider  ou refuser!');

                    }



                }
                //si tous les staatus sont ne sera pas payé impossile de valider mais que refusé
                if ($allressourcesNonPayable) {
                    return redirect()->back()->with('error', 'Vous ne pouvez pas valider cette demande car toutes les ressources ont le statut "Ne sera pas payé". Veuillez la refuser.');

                }
                // Toutes les ressources sont traitées, on peut créer les transactions pour ceux payer
                foreach ($ressources as $ressource) {
                    if ($ressource->pivot->status === 'Payer') {
                        if ($ressource->pivot->estimation_montant === null) {
                            return redirect()->back()->with('error', 'Merci d’indiquer le montant estimé pour chaque ressource marquée comme "Payer" avant de valider.');
                        }
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

                $admins = User::where('role', 'Admin')->get();

                // Envoyer notification à tous les admins
                foreach ($admins as $admin) {
                    Notification::create([
                        'user_id' => $admin->id,
                        'message' => "La demande #{$demande->id} a été validée.",
                        'is_read' => false,
                    ]);
                }

                // Envoyer notification à l'utilisateur qui a fait la demande
                Notification::create([
                    'user_id' => $demande->user_id,
                    'message' => "Votre demande #{$demande->id} a été validée.",
                    'is_read' => false,
                ]);
                //envoie email
                $user = User::findOrFail($demande->user_id);
                $url = route("message.index", ['demande' => $demande->id]);
                envoyerMail( $user,'une demande validée', "Votre demande n°{$demande->id} a été validée.",$url);


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
        $ressources = $demande->ressources;
        if ($demande->status === 'En attente') {
            foreach ($ressources as $ressource) {
                if ($ressource->pivot->status === 'A payer') {
                    return redirect()->back()->with('error', 'Veuillez traiter toutes les ressources avant de valider ou refuser !');
                }
                if($ressource->pivot->status === 'Payer'){
                    return redirect()->back()->with('error', 'Vous ne pouvez pas refuser une demande avec au moins une ressource avec un status Payer! ');

                }
            }
            $demande->status = 'Refusé';
            $demande->save();
            //envoie notif
            Notification::create([
                'user_id' => $demande->user_id,
                'message' => "Votre demande #{$demande->id} a été refusée.",

            ]);


            //envoie email
            $user = User::findOrFail($demande->user_id);
            $url = route("message.index", ['demande' => $demande->id]);
            envoyerMail( $user,'une demande refusée', "Votre demande n°{$demande->id} a été refusée.",$url);


            return redirect()->route('index.demandes')->with('success', 'Demande refusée avec succès.');

        }

        return redirect()->back()->with('error', 'Demande déjà traitée.');

    }

}
