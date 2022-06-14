@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12 ">
                <h3>Ajouter personne administrateur</h3>

            </div>

        </div>
        <a style="margin-left: -14px;" class="mb-1 btn btn-success" href="{{ route('admin.Personne_admins') }}">
            <i class="fa-solid fa-reply-all"></i> Retour</a>
        <div class="row " style="background-color: #fff;">

            <div class="col mt-3 mb-2">

                <form action="{{ route('admin.Personne_admin.store') }}" method="post">
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

                    <div class="form-group">
                        <label for="nom_prenom">Nom et prénom</label>
                        <input type="text" class="form-control" name="nom_prenom" placeholder="Entrer nom et prénom">
                        <span class="text-danger">
                            @error('nom_prenom')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>


                    <div class="form-group">
                        <label for=" telephone"> Téléphone</label>
                        <input type="text" class="form-control" name=" telephone" placeholder="Entrer téléphone">
                        <span class="text-danger">
                            @error('telephone')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" name="email" placeholder="Entrer email"
                            value="{{ old('email') }}">
                        <span class="text-danger">
                            @error('email')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" class="form-control" name="password" placeholder="Entrer mot de passe"
                            value="{{ old('password') }}">
                        <span class="text-danger">
                            @error('password')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="cpassword">Confirmer le mot de passe </label>
                        <input type="password" class="form-control" name="cpassword"
                            placeholder="Entrer confirmer le mot de passe" value="{{ old('cpassword') }}">
                        <span class="text-danger">
                            @error('cpassword')
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
