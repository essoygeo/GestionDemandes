<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use App\Models\Demande;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentaireController extends Controller
{
//   public function show($id){
//
//      $demande = Demande::findOrFail($id);
//       $ressources = $demande->ressources()->get();
//      return view('demandes.show',compact('demande','ressources'));
//   }

    public function store( Request $request ,$id){

       $validated = $request->validate([
           'contenu'=>'required|string',
       ]);

       Commentaire::create([
           'demande_id'=>$id,
           'user_id'=>Auth::id(),
           'contenu'=>$validated['contenu']


       ]);

        $demande =  Demande::findOrFail($id);
        $commentAuthorId = Auth::id();

// Notifier Admins et Comptables (sauf l'auteur du commentaire)
        $users = User::whereIn('role', ['Admin', 'Comptable'])
            ->where('id', '!=', $commentAuthorId)
            ->get();

        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'message' => "La demande #{$id} a été commentée.",
                'is_read' => false,
            ]);
        }

// Notifier le créateur de la demande s’il n’a pas écrit le commentaire
        if ($demande->user_id !== $commentAuthorId) {
            Notification::create([
                'user_id' => $demande->user_id,
                'message' => "Votre demande #{$id} a été commentée.",
                'is_read' => false,
            ]);
        }



return redirect()->route('show.demandes',['demande'=>$id])->with('success','commentaire ajouté avec succes');
    }
}
