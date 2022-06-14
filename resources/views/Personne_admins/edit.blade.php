@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12 ">
                <h3>Modifier personne administrateur</h3>
            </div>
        </div>
        <a style="margin-left: -14px;" class="mb-1 btn btn-success" href="{{ route('admin.Personne_admins') }}">
            <i class="fa-solid fa-reply-all"></i> Retour</a>
        <div class="row " style="background-color: #fff;">

            <div class="col mt-3 mb-2">
                <form action="{{ route('admin.Personne_admin.update', $Personne_admin->id) }}" method="post">


                    @if (Session::get('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    @if (Session::get('fail'))
                        <div class="alert alert-danger">
                            {{ Session::get('fail') }}
                        </div>
                    @endif

                    @csrf
                    @method('PUT')


                    <div class="form-group">
                        <label for="nom_prenom">Nom et prénom</label>
                        <input type="text" class="form-control" name="nom_prenom" placeholder="Entrer nom et prénom"
                            value="{{ $Personne_admin->nom_prenom }}">
                        <span class="text-danger">
                            @error('nom_prenom')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>


                    <div class="form-group">
                        <label for="telephone">Téléphone</label>
                        <input type="text" class="form-control" name="telephone"
                            value="{{ $Personne_admin->telephone }}" placeholder="Entrer téléphone">
                        <span class="text-danger">
                            @error('telephone')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" name="email" value="{{ $Personne_admin->email }}"
                            placeholder="Entrer email">
                        <span class="text-danger">
                            @error('email')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>


                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Sauvegarder</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
