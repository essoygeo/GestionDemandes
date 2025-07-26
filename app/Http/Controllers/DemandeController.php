<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Demande;
use App\Models\Ressource;
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
            'type' => 'required|in:Achat,En stock',
            'date' => 'required|date',
            'ressources' => 'required|array',
            'ressources.*' => 'exists:ressources,id',

        ]);
        if ($request->type === 'En stock') {
            $rules['estimation_montant'] = 'nullable';
        } else {
            $rules['estimation_montant'] = 'required|numeric|min:0';
        }
        $validated = $request->validate($rules);

        $demande = Demande::create([
            'user_id' => Auth::id(),
            'titre' => $validated['titre'],
            'raison' => $validated['raison'],
            'estimation_montant' => $validated['estimation_montant'],
            'type' => $validated['type'],
            'date' => $validated['date'],
        ]);

        //$route = Auth::user()->role ==='Employe' ? 'indexEmploye.demandes' : 'index.demandes';

//        return redirect()->route($route)
//            ->with('warning','veuillez creer la/les ressources associée(s) à cette demande')
//        ->with('success', 'demande créee avec sucess');
        $demande->ressources()->attach($validated['ressources']);

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
        $demande = Demande::with(['user', 'categorie', 'ressources.user', 'ressources.categorie','commentaires.user'])->findOrFail($id);
        $ressources = $demande->ressources()->get();


        return view('demandes.show', compact('demande','ressources','categories'));
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
        $categories = Categorie::all();

        return view('demandes.edit', compact('demande', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            // 'categorie_id' => 'required',
            'titre' => 'required|string',
            'raison' => 'required|string',
            'type' => 'required|in:Achat,En stock',
            'date' => 'required|date',
        ];

        if ($request->type === 'En stock') {
            $rules['estimation_montant'] = 'nullable';
        } else {
            $rules['estimation_montant'] = 'required|numeric|min:0';
        }

        $validated = $request->validate($rules);

        $demande = Demande::findOrFail($id); // ← on récupère la demande

        $demande->update([
            'user_id' => Auth::id(),
            //'categorie_id' => $validated['categorie_id'],
            'titre' => $validated['titre'],
            'raison' => $validated['raison'],
            'estimation_montant' => $validated['estimation_montant'] ?? null,
            'type' => $validated['type'],
            'date' => $validated['date'],
        ]);

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

}
