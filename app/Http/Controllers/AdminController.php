<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function adminDashboard()
    {

        return view('welcome.welcome');
    }

//crud user
    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role' => 'required|in:Admin,Comptable,Employe',

        ]);
        $validated['password'] = Hash::make($validated['password']);
        User::create([
            'nom' => $validated['nom'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $validated['role'],
        ]);
        return redirect()->route('index.users')->with('success', 'utilisateur créee avec sucess');
    }

    public function index()
    {
        $users = User::paginate(10);

        return view('users.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
       $curentuser =  Auth::user();
        if( $user->id !== $curentuser->id && $curentuser->role !=='Admin' ){
            abort(403,'Acces non autorisé');
        }

        return view('users.show', compact('user'));
    }

    public function update(Request $request, $user)
    {
        $user = User::findOrFail($user);
        $validated = $request->validate([
            'nom' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable',
            'role' => 'required|in:Admin,Comptable,Employe',

        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);


        return redirect()->route('index.users')->with('success', 'utilisateur modifié avec sucess');
    }

    public function edit($user)
    {
        $user = User::findOrFail($user);


        return view('users.edit', compact('user'));
    }

    public function destroy($user)
    {
        $user = User::findOrFail($user);
        $user->delete();

        return redirect()->route('index.users')->with('success', 'utilisateur suprimé avec sucess');
    }


}
