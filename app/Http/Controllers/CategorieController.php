<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CategorieController extends Controller
{
    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|unique:categories,nom',

        ]);
       $userId = Auth::id();
        Categorie::create([
            'nom' => $validated['nom'],
            'user_id'=>$userId
        ]);
        return redirect()->route('index.categories')->with('success', 'categorie créee avec sucess');
    }
    public function index()
    {
        $categories = Categorie::with('user')->paginate(10);

        return view('categories.index', compact('categories'));
    }

    public function show($categorie)
    {
        $categorie = Categorie::with('user')->findOrFail($categorie);

        return view('categories.show', compact('categorie'));
    }

    public function update(Request $request, $categorie)
    {
        $categorie = Categorie::findOrFail($categorie);

        $validated = $request->validate([
            'nom' => 'required|unique:categories,nom,' . $categorie->id,
        ]);

        $categorie->update($validated);

        return redirect()->route('index.categories')->with('success', 'Catégorie modifiée avec succès');
    }


    public function edit($categorie)
    {
        $categorie = Categorie::findOrFail($categorie);

        return view('categories.edit', compact('categorie'));
    }

    public function destroy($categorie)
    {
        $categorie = Categorie::findOrFail($categorie);
        $categorie->delete();

        return redirect()->route('index.categories')->with('success', 'categorie suprimée avec sucess');
    }


}
