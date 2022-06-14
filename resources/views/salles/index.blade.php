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

                    <h3> Types salles </h3>


                </div>
            </div>
            <div class="row">
                <div class="col">
                    @if (Session::get('Typesuccess'))
                        <div class="alert alert-success">
                            {{ Session::get('Typesuccess') }}
                        </div>
                    @endif
                    @if (Session::get('Typefail'))
                        <div class="alert alert-danger">
                            {{ Session::get('Typefail') }}
                        </div>
                    @endif

                </div>
            </div>
            <div class="perant-table mb-3">
                <div class="row first-row justify-content-between">
                    <div class="col-auto">
                        <a class="btn btn-success" href="{{ route('admin.type_salle.create') }}"> Ajouter <i
                                class="fa-solid fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="row">


                    @if ($type_salles->count() > 0)
                        <div class="col">
                            <div class="table-responsive">
                                <table class="table  table-bordered table-striped">
                                    <thead class="bg-success text-white">
                                        <tr>

                                            <th scope="col" class="col-4">Nom</th>
                                            <th scope="col" class="col-4"> Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($type_salles as $itemm)
                                            <tr>

                                                <td>{{ $itemm->type_salle }}</td>
                                                <td>
                                                    <a style="margin-top: 2px;"
                                                        href="{{ route('admin.type_salle.edit', $itemm->id) }}"
                                                        class="btn btn-primary btn-sm">Modifier
                                                        <i class="fas  fa-edit"></i>
                                                    </a>
                                                    <span style="margin-top:2px;" class="btn btn-danger btn-sm"
                                                        style="cursor: pointer;" data-toggle="modal"
                                                        data-target="#modal{{ $itemm->id }}">Supprimer <i
                                                            class="fas  fa-trash-alt"></i>
                                                    </span>


                                                    <!-- Modal -->
                                                    <div class="modal fade" id="modal{{ $itemm->id }}" tabindex="-1"
                                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        Supprimer les type salle
                                                                    </h5>

                                                                </div>
                                                                <div style="text-align: start;" class="modal-body">
                                                                    <h6>Attention</h6>
                                                                    Lors de la suppression d'un type salle
                                                                    , la salle et toutes les réservations
                                                                    pour cette base seront automatiquement supprimées
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Annuler</button>
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <a class="btn btn-danger"
                                                                        href="{{ route('admin.type_salle.destroy', $itemm->id) }}">
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
                                Pas type salle
                            </div>
                        </div>
                    @endif


                </div>
                <div class="d-felx justify-content-center col-12">

                    {{ $type_salles->links() }}

                </div>
            </div>

            <div class="row">
                <div class="col-12">

                    <h3>Salles </h3>



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
                <div class="row  first-row justify-content-between ">
                    <div class="col-auto ">
                        <a class="btn btn-success" href="{{ route('admin.salle.create') }}"> Ajouter <i
                                class="fa-solid fa-plus"></i></a>
                    </div>
                    <div class="col-auto  ">

                    <form id="all-salle" action="{{ route('admin.salles') }}" method="POST">
                        @csrf
                        <input hidden name="all_salle" type="text">
                    </form>

                        <form action="{{ route('admin.salles') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="input-group">
                                <button class="btn btn-success mr-3"
                                onclick="document.getElementById('all-materiel').submit();">Tout</button>
                                <input placeholder="Rechercher " type="search" name="code_salle"
                                    class="form-control" aria-describedby="button-addon2">
                                <span class="text-danger">
                                    @error('code_salle')
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
                </div>
                <div class="row">


                    @if ($salles->count() > 0)
                        <div class="col">
                            <div class="table-responsive">
                                <table class="table  table-bordered table-striped">
                                    {{-- <thead  style="background-color:#75ff95; color:#176329;"> --}}
                                    <thead class="bg-success text-white">
                                        <tr>
                                            <th scope="col">Code salle</th>
                                            <th scope="col"> Type</th>
                                            <th scope="col">Capacité</th>
                                            <th scope="col">Etage</th>
                                            <th scope="col">Spécial</th>


                                            <th scope="col" class="col-2">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($salles as $item)
                                            <tr>


                                                <td>{{ $item->code_salle }} </td>
                                                <td>{{ $item->typesalle->type_salle }}</td>
                                                <td>{{ $item->capacite }}</td>
                                                <td>{{ $item->etage }}</td>
                                                <td>{{ $item->special }}</td>

                                                <td>



                                                    <div>

                                                        <span class="btn btn-danger btn-sm"
                                                            style="cursor: pointer;margin:auto;" data-toggle="modal"
                                                            data-target="#modal{{ $item->code_salle }}">Supprimer
                                                            <i class="fas  fa-trash-alt"></i>
                                                        </span>


                                                        <!-- Modal -->
                                                        <div class="modal fade" id="modal{{ $item->code_salle }}"
                                                            tabindex="-1" aria-labelledby="exampleModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            Supprimer
                                                                            salle</h5>

                                                                    </div>
                                                                    <div style="text-align: start;" class="modal-body">
                                                                        <h6>Attention</h6>
                                                                        Lorsque cette salle est supprimée,
                                                                        toutes les réservations pour cette salle
                                                                        seront suprimées
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Annuler</button>
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <a class="btn btn-danger"
                                                                            href="{{ route('admin.salle.destroy', $item->code_salle) }}">
                                                                            Supprimer
                                                                        </a>
                                                                    </div>
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
                                Pas salle
                            </div>
                        </div>
                    @endif


                </div>
                <div class="d-felx justify-content-center col-12">

                    {{ $salles->appends(Request::except('page'))->links() }}

                </div>
            </div>
        </div>

    </body>

    </html>
@endsection
