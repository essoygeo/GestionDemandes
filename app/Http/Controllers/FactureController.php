<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class FactureController extends Controller
{
//    public function index(): View
//    {
//
//    }



    public function destroy($id)
    {
        $facture = Facture::findOrFail($id);

        // Supprimer le fichier physique s’il existe
        $filePath = public_path('images/' . basename($facture->path_image));
        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        $facture->delete();
        //notif de suppression
        $users = User::whereIn('role', ['Admin', 'Comptable'])->get();
        $current = Auth::user();
        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'message' => "une facture a été suprimée de la demande #{$facture->demande_id} par  l'utilisateur {$current->nom}",

            ]);
        }


        return response()->json(['message' => 'Facture supprimée avec succès']);
    }

    public function store(Request $request)
    {
        // Initialize an array to store image information
        $images = [];

        // Process each uploaded image
        foreach($request->file('files') as $image) {
            // Generate a unique name for the image
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Move the image to the desired location
            $image->move(public_path('images'), $imageName);

            // Add image information to the array
            $images[] = [
//                'name' => $imageName,
                'path_image' => asset('/images/'. $imageName),
                'filesize' => filesize(public_path('images/'.$imageName)),
                'date'=>now(),
                'demande_id'=>$request->demande_id

            ];

        }
        $users = User::whereIn('role', ['Admin', 'Comptable'])->get();
        $current = Auth::user();
        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'message' => "une facture a été ajoutée à la demande #{$request->demande_id} par  l'utilisateur {$current->nom}",

            ]);
        }

        // Store images in the database using create method
        foreach ($images as $index=> $imageData) {
           $facture = Facture::create($imageData);
            $images[$index]['id'] = $facture->id ;
        }

        return response()->json(['success'=>$images]);
    }

}
