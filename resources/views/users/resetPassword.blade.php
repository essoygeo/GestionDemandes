@extends('layouts.app')

@section('title','modifier son mot de pass ')



    <!DOCTYPE html>
<html lang="en">

@section('content')
    <div class="d-flex justify-content-center align-items-center bg-light">
        <div class="card shadow p-4" style="width: 100%; max-width: 600px;">
            <h3 class="text-center mb-4">Modifier le mot de passe</h3>



            <form method="POST" action="{{ route('update.password') }}">
                @csrf
                <div class="mb-3">
                    <label for="ancien_password" class="form-label">Ancien mot de passe</label>
                    <input type="password" class="form-control" id="ancien_password" name="ancien_password" placeholder="ancien mot de pass" required>
                </div>

                <div class="mb-3">
                    <label for="nouveau_password" class="form-label">Nouveau mot de passe</label>
                    <input type="password" class="form-control" id="nouveau_password" name="nouveau_password" placeholder="nouveau mot de pass" required>
                </div>

                <div class="mb-3">
                    <label for="confirmation_password" class="form-label">Confirmer le nouveau mot de passe</label>
                    <input type="password" class="form-control" id="confirmation_password" name="confirmation_password"  placeholder="confirmer mot de pass" required>
                </div>

                <button type="submit" class="btn btn-success w-100">
                    Mettre à jour
                </button>
            </form>
        </div>
    </div>

@endsection








