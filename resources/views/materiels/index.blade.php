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
            <div class="row">
                <div class="col-12">

                    <h3>Matériel </h3>



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
            <div class="perant-table ">
                <div class="first-row row justify-content-between ">
                    <div class="col-auto ">
                        <a class="btn btn-success" href="{{ route('admin.materiel.create') }}"> Ajouter
                            <i class="fa-solid fa-plus"></i></a>
                    </div>
                    <div class="col-auto  ">
                        <form id="all-materiel" action="{{ route('admin.materiels') }}" method="POST">
                            @csrf
                            <input hidden name="all_materiel" type="text">
                        </form>
                        <form action="{{ route('admin.materiels') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="input-group">
                                <button class="btn btn-success mr-3"
                                    onclick="document.getElementById('all-materiel').submit();">Tout</button>
                                <input placeholder="Rechercher " type="search" name="nom" class="form-control">
                                <span class="text-danger" aria-describedby="button-addon2">
                                    @error('nom')
                                        {{ $message }}
                                    @enderror
                                </span>



                                <div class="input-group-append">

                                    <button type="submit " id="button-addon2" class="btn btn-outline-success "><i
                                            class="fa-solid fa-magnifying-glass " style="font-size: 18px"></i></button>
                                </div>

                            </div>


                        </form>
                    </div>

                    </form>
                </div>
                <div class="row">


                    @if ($materiels->count() > 0)
                        <div class="col">
                            <div class="table-responsive">
                                <table class="table  table-bordered table-striped">

                                    <thead class="bg-success text-white">
                                        <tr>

                                            <th scope="col">N-série</th>
                                            <th scope="col"> Nom</th>
                                            <th scope="col">Marque</th>
                                            <th scope="col">Description</th>
                                            <th scope="col" class="col-3">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($materiels as $item)
                                            <tr>


                                                <td>{{ $item->n_serie }}</td>
                                                <td>{{ $item->nom }}</td>
                                                <td>{{ $item->marque }}</td>
                                                <td>{{ $item->desecription }}</td>

                                                <td>




                                                    <a style="margin-top: 2px;"
                                                        href="{{ route('admin.materiel.edit', $item->id) }}"
                                                        class="btn btn-primary btn-sm">Modifier
                                                        <i class="fas  fa-edit"></i>
                                                    </a>

                                                    <span style="margin-top: 2px;" class="btn btn-danger btn-sm"
                                                        style="cursor: pointer;" data-toggle="modal"
                                                        data-target="#modal{{ $item->id }}">Supprimer <i
                                                            class="fas  fa-trash-alt "></i>
                                                    </span>


                                                    <!-- Modal -->
                                                    <div class="modal fade" id="modal{{ $item->id }}" tabindex="-1"
                                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        Supprimer
                                                                        matériel</h5>

                                                                </div>
                                                                <div style="text-align: start;" class="modal-body">
                                                                    Es-tu sur ?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">annuler</button>
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <a class="btn btn-danger"
                                                                        href="{{ route('admin.materiel.destroy', $item->id) }}">
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
                                Pas matériel
                            </div>
                        </div>
                    @endif


                </div>
                <div class="d-felx justify-content-center col-12">
                    {{ $materiels->appends(Request::except('page'))->links() }}

                </div>
            </div>
        </div>

    </body>

    </html>
@endsection
