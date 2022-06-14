@extends('layouts.Personne_admin')


@section('content')
    <div class="container ">

        <div class="row  justify-content-between align-items-center" style="margin-top:80px ">

            <div class="col-md-6 col-12 profil-left " style="margin-bottom: 20px">
                <div class="card border-success">

                    <div class="card-body">
                        <h5 class="card-title">Profile</h5>
                        <p class="card-text">
                        <table class="profile" style="100%">

                            <tr>
                                <th>Nom et prénom</th>
                                <td>{{ $Personne_admin->nom_prenom }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $Personne_admin->email }}</td>
                            </tr>
                            <tr>
                                <th>Téléphone</th>
                                <td>{{ $Personne_admin->telephone }}</td>
                            </tr>

                        </table>
                        </p>

                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12 profil-right  ">
                <div class="card border-success">


                    <div class="card-body">
                        <h5 class="card-title">Modifié profile</h5>
                        <form action="{{ route('Personne_admin.Personne_admin.passupdate', $Personne_admin->id) }}" method="post"
                            autocomplete="off">
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
                                <label for="telephone">Téléphone</label>
                                <input type="number" class="form-control" name="telephone" placeholder="Entrer téléphone"
                                    value="{{ $Personne_admin->telephone }}">
                                <span class="text-danger">
                                    @error('telephone')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="password">Mot de passe</label>
                                <input type="password" class="form-control" name="oldpassword"
                                    placeholder="Entrer l'ancien mot de passe">
                                <span class="text-danger">
                                    @error('oldpassword')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="cpassword">Nouveau mot de passe</label>
                                <input type="password" class="form-control" name="newpassword"
                                    placeholder="Entrer confirmer le mot de passe">
                                <span class="text-danger">
                                    @error('newpassword')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>



                            <div class="form-group">
                                <button type="submit" class="btn btn-success w-100">Sauvegarder</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
