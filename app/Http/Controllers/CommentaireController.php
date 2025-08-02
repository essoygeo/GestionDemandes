<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use App\Models\Demande;
use App\Models\Notification;
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

        Notification::create([
            'user_id' => $admin->id,
            'message' => "La demande #{$demande->id} a été validée.",
            'is_read' => false,
        ]);



return redirect()->route('show.demandes',['demande'=>$id])->with('success','commentaire ajouté avec succes');
    }
}
