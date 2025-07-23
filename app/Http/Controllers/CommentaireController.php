<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use App\Models\Demande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentaireController extends Controller
{
   public function show($id){

      $demande = Demande::with(['user','commentaires.user'])->findOrFail($id);
      return view('demandes.show',compact('demande'));
   }

    public function store( Request $request ,$id){

       $validated = $request->validate([
           'contenu'=>'required|string',
       ]);

       Commentaire::create([
           'demande_id'=>$id,
           'user_id'=>Auth::id(),
           'contenu'=>$validated['contenu']


       ]);

       return redirect()->route('show.demandes',['demande'=>$id])->with('success','commentaire ajouté avec succes');
    }
}
