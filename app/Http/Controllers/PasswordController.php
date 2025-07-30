<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function edit(){
        return view('users.resetPassword');
    }


    public  function update(Request $request){
        $request->validate([
            'ancien_password'=>'required',
            'nouveau_password'=>'required|confirmed',

        ]);

        $user = Auth::user();
        if(!Hash::check($request->ancien_password,$user->password)){
            return back()->with('error', 'L’ancien mot de passe est incorrect.');
        }
        $user->password = Hash::make($request->nouveau_password);
        $user->save();

        return back()->with('success', 'Mot de passe mis à jour avec succès.');
    }
}
