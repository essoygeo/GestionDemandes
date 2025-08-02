<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use Illuminate\Http\Request;
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

        // Store images in the database using create method
        foreach ($images as $index=> $imageData) {
           $facture = Facture::create($imageData);
            $images[$index]['id'] = $facture->id ;
        }

        return response()->json(['success'=>$images]);
    }

}
