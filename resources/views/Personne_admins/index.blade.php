@extends('layouts.app')

@section('content')

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">


    </head>

    <body>
        <div class="container-fluid">
            <div class="row ">
                <div class="col-12">

                    <h3>Personnes administrateurs </h3>






                </div>
            </div>



            <div class="row">
                <div class="col">
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

                </div>
            </div>
            <div class="perant-table">
                <div class="row first-row justify-content-between ">
                    <div class="col-auto ">
                        <a class="btn btn-success" href="{{ route('admin.Personne_admin.create') }}"> Ajouter <i
                                class="fa-solid fa-plus"></i>
                        </a>
                    </div>
                    <div class="col-auto  ">


                    <form id="all-personne" action="{{ route('admin.Personne_admins') }}" method="POST">
                        @csrf
                        <input hidden name="all_personne" type="text">
                    </form>

                        <form action="{{ route('admin.Personne_admins') }}" method="POST" enctype="multipart/form-data">
                            @csrf





                            <div class="input-group">
                                <button class="btn btn-success mr-3"
                                onclick="document.getElementById('all-personne').submit();">Tout</button>
                                <span class="text-danger">
                                    @error('Personne_admin')
                                        {{ $message }}
                                    @enderror
                                </span>
                                <input placeholder="Rechercher " type="search" name="Personne_admin"
                                    class="form-control" aria-describedby="button-addon2">
                                <div class="input-group-append">

                                    <button type="submit " id="button-addon2" class="btn btn-outline-success "><i
                                            class="fa-solid fa-magnifying-glass " style="font-size: 18px"></i></button>
                                </div>

                            </div>


                        </form>
                    </div>
                </div>
                <div class="row">


                    @if ($Personne_admins->count() > 0)
                        <div class="col">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">

                                    <thead class="bg-success text-white">
                                        <tr>


                                            <th scope="col"><i class="fa-regular fa-address-card"></i> Nom et prénom </th>
                                            <th scope="col"><i class="fa-solid fa-phone"></i> Téléphone </th>
                                            <th scope="col"> <i class="fa-regular fa-envelope"></i> Email </th>

                                            <th scope="col">Actions</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($Personne_admins as $item)
                                            <tr>



                                                <td>{{ $item->nom_prenom }}</td>
                                                <td>{{ $item->telephone }}</td>

                                                <td>{{ $item->email }}</td>


                                                <td>




                                                    <a style="margin-top: 2px;"
                                                        href="{{ route('admin.Personne_admin.edit', $item->id) }}"
                                                        class=" btn btn-primary  btn-sm ">Modifier
                                                        <i class="fas  fa-edit "></i>

                                                    </a>

                                                    <span style="margin-top: 2px;" class="btn btn-danger     btn-sm"
                                                        style="cursor: pointer;" data-toggle="modal"
                                                        data-target="#modal{{ $item->id }}">Supprimer <i
                                                            class="fas  fa-trash-alt"></i>
                                                    </span>


                                                    <!-- Modal -->
                                                    <div class="modal fade" id="modal{{ $item->id }}" tabindex="-1"
                                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        Supprimer
                                                                        Personne admin</h5>

                                                                </div>
                                                                <div style="text-align: start;" class="modal-body">
                                                                    Es-tu sur ?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Annuler</button>
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <a class="btn btn-danger"
                                                                        href="{{ route('admin.Personne_admin.destroy', $item->id) }}">
                                                                        Supprimer
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>



                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>

                            </div>


                        </div>
                    @else
                        <div class="col">
                            <div class="alert alert-danger" role="alert">
                                Pas personnes administrateurs
                            </div>
                        </div>
                    @endif


                </div>
                <div class="d-felx justify-content-center col-12">


                    {{ $Personne_admins->appends(Request::except('page'))->links() }}

                </div>
            </div>

        </div>

    </body>

    </html>
@endsection
