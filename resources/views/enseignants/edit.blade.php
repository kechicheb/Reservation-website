@extends('layouts.app')


@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12 ">
                <h3>Modifier enseignant</h3>
            </div>



        </div>
        <a style="margin-left: -14px;" class="mb-1 btn btn-success" href="{{ route('admin.enseignants') }}">
            <i class="fa-solid fa-reply-all"></i> Retour</a>
        <div class="row " style="background-color: #fff;">

            <div class="col mt-3 mb-2">
                <form action="{{ route('admin.enseignant.update', $enseignant->matricule) }}" method="post"
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
                        <label for="nom_prenom">Nom et prénom </label>
                        <input type="text" class="form-control" name="nom_prenom" placeholder="Entrer nom et prénom"
                            value="{{ $enseignant->nom_prenom}}">
                        <span class="text-danger">
                            @error('nom_prenom')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>




                    <div class="form-group">
                        <label for="telephone">Téléphone</label>
                        <input type="number" class="form-control" name="telephone" placeholder=" Entrer téléphone"
                            value="{{ $enseignant->telephone }}">
                        <span class="text-danger">
                            @error('telephone')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>


                    <div class="form-group">
                        <label for="type_status">Type status</label>
                        <select id="type_status" name="type_status" class="form-control">
                            @foreach ($status as $item)
                                <option value="{{ $item->type_status }}"
                                    {{ $item->type_status == $enseignant->type_status ? 'selected' : '' }}>
                                    {{ $item->type_status }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger">
                            @error('type_status')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="departement">Département</label>
                        <select id="departement" name="nom_dp" class="form-control">
                            @foreach ($departements as $item)
                                <option value="{{ $item->nom_dp }}"
                                    {{ $item->code_dp == $enseignant->code_dp ? 'selected' : '' }}>
                                    {{ $item->nom_dp }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger">
                            @error('nom_dp')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="type_etat"
                            {{ $enseignant->type_etat == 'active' ? 'checked' : '' }}>

                        <label class="form-check-label" for="exampleCheck1">Active</label>
                        <span class="text-danger">
                            @error('type_etat')
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
