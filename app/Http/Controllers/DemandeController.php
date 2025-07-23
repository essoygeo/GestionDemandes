<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Demande;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DemandeController extends Controller
{
    public function create()
    {
        $categories = Categorie::all();
        return view('demandes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $rules = ([
            'categorie_id' => 'required',
            'titre' => 'required|string',
            'raison' => 'required|string',
            'type' => 'required|in:Achat,En stock',
            'date' => 'required|date',

        ]);
        if ($request->type === 'En stock') {
            $rules['estimation_montant'] = 'nullable';
        } else {
            $rules['estimation_montant'] = 'required|numeric|min:0';
        }
        $validated = $request->validate($rules);

      $demande =  Demande::create([
            'user_id' => Auth::id(),
            'categorie_id' => $validated['categorie_id'],
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


               return redirect()->route('create.ressources',['demande'=>$demande->id])->with('success', 'Demande créee avec succès')
                   ->with('warning','veuillez creer la/les ressources associée(s) à cette demande');



    }

    public function index()
    {
        $demandes = Demande::with('user', 'categorie')->paginate(10);

        if(Auth::user()->role ==='Employe'){
           return redirect()->route('indexEmploye.demandes');
        }

        return view('demandes.index', compact('demandes'));


    }

    public function show($demande)
    {
        $demande = Demande::with('user', 'categorie')->findOrFail($demande);

        return view('demandes.show', compact('demande'));
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
            'categorie_id' => 'required',
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
            'categorie_id' => $validated['categorie_id'],
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

    public function indexRole()
    {
        $user = Auth::user();
        $demandes = $user->demandes()->with('categorie')->paginate(10);

        return view('demandes.index_user', compact('demandes'));
    }

}
