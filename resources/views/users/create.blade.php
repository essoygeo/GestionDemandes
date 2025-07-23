@extends('templates.dashboard')
@section('title','creer un utililsateur')
@section('content')

    <div class="container d-flex justify-content-center align-items-center min-vh-100 bg-light">
        <div class="card shadow p-4" style="width: 100%; max-width: 1000px;">
            <h3 class="text-center mb-4"> Formulaire de creation</h3>

            <form method="POST" action="{{ route('store.users') }}">
                @csrf

                <div class="mb-3">
                    <label for="nom" class="form-label">Nom et Prenom</label>
                    <input type="text" class="form-control" name="nom" id="nom"  placeholder="saisir nom et prenom" required >
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Adresse email</label>
                    <input type="email" class="form-control" name="email" id="email"  placeholder="saisir email" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="saisir mot de pass" required>
                </div>

                <div class="mb-3 form-check">
                    <input class="form-check-input" type="radio" name="role" value="Employe" id="employe">
                    <label class="form-check-label" for="employe">
                        Employe
                    </label>
                </div>

                <div class="mb-3 form-check">
                    <input class="form-check-input" type="radio" name="role" value="Comptable" id="comptable">
                    <label class="form-check-label" for="comptable">
                        Comptable
                    </label>
                </div>

                <div class="mb-3 form-check">
                    <input class="form-check-input" type="radio" name="role" value="Admin" id="admin">
                    <label class="form-check-label" for="admin">
                        Admin
                    </label>
                </div>

                <button type="submit" class="btn  btn-violet w-100" >
                   creer
                </button>
            </form>
        </div>
    </div>
@endsection
