@extends('layouts.app')
@section('title','modifier categoreie')
@section('content')
    <div class="d-flex justify-content-center align-items-center bg-light">
        <div class="card shadow p-4" style="width: 100%; max-width: 1000px;">
            <h3 class="text-center mb-4"> Formulaire de modification</h3>

            <form method="POST" action="{{ route('update.categories',['categorie'=>$categorie->id]) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nom" class="form-label">Nom categorie</label>
                    <input type="text" class="form-control" name="nom" id="nom" value="{{$categorie->nom}}" placeholder="saisir nom categorie"required  >
                </div>


                <button type="submit" class="btn btn-success w-100" >
                    modifier
                </button>
            </form>
        </div>
    </div>

@endsection
