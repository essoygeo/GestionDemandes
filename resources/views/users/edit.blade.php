@extends('templates.dashboard')
@section('title','modifier utililsateur')
@section('content')

    <div class="container d-flex justify-content-center align-items-center min-vh-100 bg-light">
        <div class="card shadow p-4" style="width: 100%; max-width: 1000px;">
            <h3 class="text-center mb-4">Formulaire de modification</h3>

            <form method="POST" action="{{ route('update.users',['user'=>$user->id]) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nom" class="form-label">Nom et Prenom</label>

                    <input type="text" class="form-control" name="nom" id="nom"  placeholder="saisir nom et prenom" value="{{$user->nom}}" required >
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Adresse email</label>

                    <input type="email" class="form-control" name="email" id="email"  value="{{$user->email}}" placeholder="saisir email" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" name="password" id="password"  placeholder="saisir nouveau mot de pass" >
                </div>

                <div class="mb-3 form-check">

                    <input class="form-check-input" type="radio" name="role" value="Employe" id="employe"
                        {{ old('role', $user->role) === 'Employe' ? 'checked' : '' }}>
                    <label class="form-check-label" for="employe">
                        Employe
                    </label>
                </div>

                <div class="mb-3 form-check">
                    <input class="form-check-input" type="radio" name="role" value="Comptable" id="comptable"
                        {{ old('role', $user->role) === 'Comptable' ? 'checked' : '' }}>
                    <label class="form-check-label" for="comptable">
                        Comptable
                    </label>
                </div>

                <div class="mb-3 form-check">

                    <input class="form-check-input" type="radio" name="role" value="Admin" id="admin"
                        {{(old('role',$user->role)==='Admin')  ? 'checked': ''}}>
                    <label class="form-check-label" for="admin">
                        Admin
                    </label>
                </div>

                <button type="submit" class="btn  btn-violet w-100" >
                    modifier
                </button>
            </form>
        </div>
    </div>
@endsection

