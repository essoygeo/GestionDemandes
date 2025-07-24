@extends('layouts.app')
@section('title','details utililsateur')
@section('content')



    <div class="d-flex justify-content-center align-items-center bg-light">
        <div class="card shadow p-4" style="width: 100%; max-width: 1000px;">
            <h3 class="text-center mb-4"><span>Details de l'utilisateur {{$user->nom}}</span>
            </h3>

            <form>
                @csrf

                <div class="mb-3">
                    <label for="nom" class="form-label">Nom et Prenom</label>

                    <input type="text" class="form-control" name="nom" id="nom" placeholder="saisir nom et prenom"
                           value="{{$user->nom}}" readonly required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Adresse email</label>

                    <input type="email" class="form-control" name="email" id="email" value="{{$user->email}}"
                           placeholder="saisir email" readonly required autofocus>
                </div>


                <div class="mb-3 form-check">

                    <input class="form-check-input" type="radio" name="role" value="Employe" id="employe"
                        {{ old('role', $user->role) === 'Employe' ? 'checked' : 'disabled' }}>
                    <label class="form-check-label" for="employe">
                        Employe
                    </label>
                </div>

                <div class="mb-3 form-check">
                    <input class="form-check-input" type="radio" name="role" value="Comptable" id="comptable"
                        {{ old('role', $user->role) === 'Comptable' ? 'checked' : 'disabled' }}>
                    <label class="form-check-label" for="comptable">
                        Comptable
                    </label>
                </div>

                <div class="mb-3 form-check">

                    <input class="form-check-input" type="radio" name="role" value="Admin" id="admin"
                        {{(old('role',$user->role)==='Admin')  ? 'checked': 'disabled'}}>
                    <label class="form-check-label" for="admin">
                        Admin
                    </label>
                </div>
                <div class="mb-3">
                    <a href="javascript:history.back()" class="btn btn-success w-100">
                        <i class="fas fa-arrow-left"></i> retour
                    </a>
                </div>
            </form>

        </div>

    </div>

@endsection
