@extends('layouts.enseignant')


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
                                <th>matricule</th>
                                <td>{{ $enseignant->matricule }}</td>
                            </tr>
                            <tr>
                                <th>Nom et prénom</th>
                                <td>{{ $enseignant->nom_prenom }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $enseignant->email }}</td>
                            </tr>
                            <tr>
                                <th>Téléphone</th>
                                <td>{{ $enseignant->telephone }}</td>
                            </tr>
                            <tr>
                                <th>Dépatrement</th>
                                <td>{{ $enseignant->departement->nom_dp }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ $enseignant->typestatus->type_status }}</td>
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
                        <form action="{{ route('enseignant.enseignant.passupdate', $enseignant->matricule) }}"
                            method="post" autocomplete="off">
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
                                    value="{{ $enseignant->telephone }}">
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
                                <input pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                    title="8 characters minimum, 1 capital letter minimum, 1 small letter minimum, 1 number minimum."
                                    type="password" class="form-control" name="newpassword"
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
