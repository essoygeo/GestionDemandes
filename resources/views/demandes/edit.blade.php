@extends('layouts.app')
@section('title','modifier demande')
@section('content')

    <div class="d-flex justify-content-center align-items-center bg-light  mb-3">
        <div class="card shadow p-4" style="width: 100%; max-width: 1000px;">
            <h3 class="text-center mb-4"> Formulaire de modification</h3>
            <form action="{{route('update.demandes',['demande'=>$demande->id])}}" method="post">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-10 mb-3">
                        <label for="ressources" class="form-label">Ressources de la demande</label>
                        <select class="form-select" name="ressources[]" multiple>
                            @foreach($ressources as $ressource)
                                <option value="{{ $ressource->id }}"
                                        @if(in_array($ressource->id, $ressourcesActuelles)) selected @endif>
                                    {{ $ressource->nom }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Utilisez Ctrl (Windows) ou Cmd (Mac) pour sélectionner plusieurs ressources.</small>
                    </div>

                </div>
                <div class="mb-3">
                    <label for="titre" class="form-label">Titre de la demande </label>
                    <input type="text" class="form-control" name="titre" id="titre" value="{{$demande->titre}}">
                </div>

                <div class="mb-3">
                    <label for="raison" class="form-label">Raison de la demande</label>
                    <textarea
                        class="form-control"
                        rows="4"
                        id="raison"
                        name="raison"
                    >{{$demande->raison}}</textarea>
                </div>

{{--                <div class="mb-3">--}}
{{--                    <label for="date" class="form-label">Date de creation</label>--}}
{{--                    <input type="date"  class="form-control" name="date"--}}
{{--                           id="date"  value="{{$demande->created_at->format('y/m/d')}}">--}}
{{--                </div>--}}

                <button type="submit"  class="btn  btn-success w-100" href="{{route('index.demandes')}}">
                    modifier
                </button>
            </form>
        </div>
    </div>





@endsection
